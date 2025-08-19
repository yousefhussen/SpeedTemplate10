<?php

namespace Modules\Profile\Http\Controllers;

use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function index()
    {
        $user = request()->user(); // Get the authenticated user

        // Retrieve cart items with related item details
        $cartItems = \Modules\Profile\Entities\Cart::where('user_id', $user->id)
            ->with(['item_attribute','item_attribute.item'])
            ->get();

        return \Modules\Profile\Http\Resources\CartResource::collection($cartItems);

    }

    public function store(\Modules\Profile\Http\Requests\CartRequest $request)
    {
        $user = $request->user(); // Get the authenticated user
        $itemAttrId = $request->validated()['item_attributes_id']; // Get the validated item_attributes_id
        $quantity = $request->validated()['quantity']; // Get the quantity

        // Retrieve the item attribute
        $itemAttribute = \Modules\Product\Entities\ItemAttribute::find($itemAttrId);

        if (!$itemAttribute || $itemAttribute->amount < $quantity) {
            return response()->json(['message' => 'Insufficient stock'], 400);
        }

        // Check if the item already exists in the user's cart
        $cartItem = \Modules\Profile\Entities\Cart::where('user_id', $user->id)
            ->where('item_attributes_id', $itemAttrId)
            ->first();

        if ($cartItem) {
            // Increase the quantity in the cart
            $cartItem->increment('quantity', $quantity);
        } else {
            // Add the item to the cart
            \Modules\Profile\Entities\Cart::create([
                'user_id' => $user->id,
                'item_attributes_id' => $itemAttrId,
                'quantity' => $quantity,
            ]);
        }

        // Update the item attribute's on hold count and amount
        $itemAttribute->increment('on_hold_count', $quantity);
        $itemAttribute->decrement('amount', $quantity);

        return response()->json(['message' => 'Item added to cart successfully'], 201);
    }

    //decrease the quantity of an item in the cart
    public function decreaseQuantity($cartItemId)
    {
        if (!is_numeric($cartItemId)) {
            return response()->json(['message' => 'Invalid cart item ID', 'success' => false], 400);
        }
        $user = auth()->user(); // Get the authenticated user

        // Find the cart item
        $cartItem = \Modules\Profile\Entities\Cart::where('user_id', $user->id)
            ->where('item_attributes_id', $cartItemId)
            ->first();

        if (!$cartItem) {
            return response()->json(['message' => 'Item not found in cart' , 'success' => false], 404);
        }

        // Decrease the quantity
        if ($cartItem->quantity > 1) {
            $cartItem->decrement('quantity');
        } else {
            // If quantity is 1, remove the item from the cart
            $cartItem->delete();
        }

        // Update the item attribute's on hold count and amount
        $itemAttribute = \Modules\Product\Entities\ItemAttribute::find($cartItem->item_attributes_id);
        if ($itemAttribute) {
            $itemAttribute->decrement('on_hold_count');
            $itemAttribute->increment('amount');
        }

        return response()->json(['message' => 'Item quantity updated successfully' , 'success' => true], 200);
    }

    //increase the quantity of an item in the cart
    public function increaseQuantity($cartItemId)
    {
        if (!is_numeric($cartItemId)) {
            return response()->json(['message' => 'Invalid cart item attribute ID', 'success' => false], 400);
        }
        $user = \Auth::user(); // Get the authenticated user

        // Find the cart item
        $cartItem = \Modules\Profile\Entities\Cart::where('user_id', $user->id)
            ->where('item_attributes_id', $cartItemId)
            ->first();

        if (!$cartItem) {
            return response()->json(['message' => 'Item Attribute not found in cart' , 'success' => false], 404);
        }

        // Retrieve the item attribute
        $itemAttribute = \Modules\Product\Entities\ItemAttribute::find($cartItem->item_attributes_id);

        if (!$itemAttribute || $itemAttribute->amount < 1) {
            return response()->json(['message' => 'Insufficient stock' , 'success' => false], 400);
        }

        // Increase the quantity
        $cartItem->increment('quantity');

        // Update the item attribute's on hold count and amount
        $itemAttribute->increment('on_hold_count');
        $itemAttribute->decrement('amount');

        return response()->json(['message' => 'Item Attribute quantity updated successfully' , 'success' => true], 200);
    }

    //remove an item from the cart
    public function destroy($cartItemId)
    {
        if (!is_numeric($cartItemId)) {
            return response()->json(['message' => 'Invalid cart item attribute ID', 'success' => false], 400);
        }
        $user = auth()->user(); // Get the authenticated user

        // Find the cart item
        $cartItem = \Modules\Profile\Entities\Cart::where('user_id', $user->id)
            ->where('item_attributes_id', $cartItemId)
            ->first();

        if (!$cartItem) {
            return response()->json(['message' => 'Item not Attribute found in cart','success' => false], 404);
        }

        // Update the item attribute's on hold count and amount
        $itemAttribute = \Modules\Product\Entities\ItemAttribute::find($cartItem->item_attributes_id);
        if ($itemAttribute) {
            $itemAttribute->decrement('on_hold_count', $cartItem->quantity);
            $itemAttribute->increment('amount', $cartItem->quantity);
        }

        // Delete the cart item
        $cartItem->delete();

        return response()->json(['message' => 'Item removed from cart successfully' , 'success' => true], 200);
    }

//    clear cart
    public function clearCart()
    {
        $user = auth()->user(); // Get the authenticated user

        // Retrieve all cart items for the user
        $cartItems = \Modules\Profile\Entities\Cart::where('user_id', $user->id)->get();

        // Update item attributes and delete cart items
        foreach ($cartItems as $cartItem) {
            $itemAttribute = \Modules\Product\Entities\ItemAttribute::find($cartItem->item_attributes_id);
            if ($itemAttribute) {
                $itemAttribute->decrement('on_hold_count', $cartItem->quantity);
                $itemAttribute->increment('amount', $cartItem->quantity);
            }
            $cartItem->delete();
        }

        return response()->json(['message' => 'Cart cleared successfully', 'success' => true], 200);
    }
}
