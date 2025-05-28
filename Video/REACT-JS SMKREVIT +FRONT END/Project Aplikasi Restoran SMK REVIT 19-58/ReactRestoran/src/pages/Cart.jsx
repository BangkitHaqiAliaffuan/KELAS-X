"use client"

import { useState } from "react"
import { useNavigate } from "react-router-dom"
import { Minus, Plus, X, ShoppingBag, ArrowLeft, Heart, Share2 } from "lucide-react"
import { useCart } from "../context/CartContext"
import { useAuth } from "../context/AuthContext"
import axios from "axios"
import Toast from "./ui/toast"

const Cart = () => {
  const navigate = useNavigate()
  const { cartItems, removeFromCart, updateQuantity, getCartTotal, clearCart } = useCart()
  const { user, isAuthenticated } = useAuth()
  const [loading, setLoading] = useState(false)
  const [toast, setToast] = useState(null)

  const handleQuantityChange = (menuId, newQuantity) => {
    if (newQuantity < 1) {
      removeFromCart(menuId)
    } else {
      updateQuantity(menuId, newQuantity)
    }
  }

  const handleCheckout = async () => {
    if (!isAuthenticated) {
      navigate("/customer-login", { state: { message: "Please login to checkout" } })
      return
    }

    setLoading(true)
    try {
      const orderData = {
        idpelanggan: user.idpelanggan || user.id,
        items: cartItems.map((item) => ({
          idmenu: item.idmenu,
          jumlah: item.quantity,
          hargajual: item.harga,
        })),
      }

      const response = await axios.post("http://localhost:8000/api/orders/checkout", orderData, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
          Accept: "application/json",
          "Content-Type": "application/json",
        },
      })

      if (response.data.status) {
        clearCart()
        setToast({ message: "Order placed successfully!", type: "success" })
        setTimeout(() => {
          navigate("/order-history")
        }, 2000)
      }
    } catch (error) {
      console.error("Checkout error:", error)
      setToast({ message: "Failed to place order. Please try again.", type: "error" })
    } finally {
      setLoading(false)
    }
  }

  const moveToWishlist = (item) => {
    // Add to wishlist logic here
    removeFromCart(item.idmenu)
    setToast({ message: "Item moved to wishlist", type: "success" })
  }

  const subtotal = getCartTotal()
  const tax = subtotal * 0.1 // 10% tax
  const delivery = subtotal > 100000 ? 0 : 15000 // Free delivery over 100k
  const total = subtotal + tax + delivery

  if (cartItems.length === 0) {
    return (
      <div className="min-h-screen bg-gray-50 py-12">
        <div className="container mx-auto px-4">
          <div className="max-w-md mx-auto text-center">
            <div className="bg-white rounded-2xl shadow-sm p-12">
              <ShoppingBag className="w-24 h-24 text-gray-300 mx-auto mb-6" />
              <h2 className="text-2xl font-bold text-gray-900 mb-4">Your Cart is Empty</h2>
              <p className="text-gray-600 mb-8">Looks like you haven't added any items to your cart yet.</p>
              <button
                onClick={() => navigate("/menu")}
                className="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center space-x-2 mx-auto"
              >
                <ArrowLeft className="w-5 h-5" />
                <span>Continue Shopping</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    )
  }

  return (
    <div className="min-h-screen bg-gray-50 py-8">
      <div className="container mx-auto px-4">
        {/* Header */}
        <div className="flex items-center justify-between mb-8">
          <div className="flex items-center space-x-4">
            <button
              onClick={() => navigate("/menu")}
              className="p-2 hover:bg-white rounded-lg transition-colors duration-200"
            >
              <ArrowLeft className="w-5 h-5" />
            </button>
            <div>
              <h1 className="text-3xl font-bold text-gray-900">Shopping Cart</h1>
              <p className="text-gray-600">
                {cartItems.reduce((sum, item) => sum + item.quantity, 0)} items in your cart
              </p>
            </div>
          </div>
        </div>

        <div className="grid lg:grid-cols-3 gap-8">
          {/* Cart Items */}
          <div className="lg:col-span-2 space-y-4">
            {cartItems.map((item) => (
              <div key={item.idmenu} className="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div className="flex flex-col md:flex-row gap-6">
                  {/* Product Image */}
                  <div className="flex-shrink-0">
                    <img
                      src={`http://localhost:8000/${item.gambar}`}
                      alt={item.menu}
                      className="w-full md:w-32 h-32 object-cover rounded-lg"
                    />
                  </div>

                  {/* Product Details */}
                  <div className="flex-1">
                    <div className="flex justify-between items-start mb-4">
                      <div>
                        <h3 className="text-lg font-semibold text-gray-900">{item.menu}</h3>
                        <p className="text-gray-600">{item.kategori}</p>
                        <p className="text-lg font-bold text-orange-600 mt-2">
                          Rp {item.harga.toLocaleString("id-ID")}
                        </p>
                      </div>
                      <button
                        onClick={() => removeFromCart(item.idmenu)}
                        className="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors duration-200"
                      >
                        <X className="w-5 h-5" />
                      </button>
                    </div>

                    {/* Quantity and Actions */}
                    <div className="flex items-center justify-between">
                      <div className="flex items-center space-x-3">
                        <span className="text-sm font-medium text-gray-700">Quantity:</span>
                        <div className="flex items-center space-x-2">
                          <button
                            onClick={() => handleQuantityChange(item.idmenu, item.quantity - 1)}
                            className="p-2 hover:bg-gray-100 rounded-lg transition-colors duration-200"
                          >
                            <Minus className="w-4 h-4" />
                          </button>
                          <span className="w-12 text-center font-medium">{item.quantity}</span>
                          <button
                            onClick={() => handleQuantityChange(item.idmenu, item.quantity + 1)}
                            className="p-2 hover:bg-gray-100 rounded-lg transition-colors duration-200"
                          >
                            <Plus className="w-4 h-4" />
                          </button>
                        </div>
                      </div>

                      <div className="flex items-center space-x-3">
                        <button
                          onClick={() => moveToWishlist(item)}
                          className="flex items-center space-x-1 text-gray-600 hover:text-orange-600 transition-colors duration-200"
                        >
                          <Heart className="w-4 h-4" />
                          <span className="text-sm">Save for later</span>
                        </button>
                        <button className="flex items-center space-x-1 text-gray-600 hover:text-orange-600 transition-colors duration-200">
                          <Share2 className="w-4 h-4" />
                          <span className="text-sm">Share</span>
                        </button>
                      </div>
                    </div>

                    {/* Subtotal */}
                    <div className="mt-4 pt-4 border-t border-gray-100">
                      <div className="flex justify-between items-center">
                        <span className="text-sm text-gray-600">Subtotal:</span>
                        <span className="font-semibold text-gray-900">
                          Rp {(item.harga * item.quantity).toLocaleString("id-ID")}
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            ))}
          </div>

          {/* Order Summary */}
          <div className="lg:col-span-1">
            <div className="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-8">
              <h3 className="text-lg font-semibold text-gray-900 mb-6">Order Summary</h3>

              <div className="space-y-4 mb-6">
                <div className="flex justify-between">
                  <span className="text-gray-600">Subtotal</span>
                  <span className="font-medium">Rp {subtotal.toLocaleString("id-ID")}</span>
                </div>
                <div className="flex justify-between">
                  <span className="text-gray-600">Tax (10%)</span>
                  <span className="font-medium">Rp {tax.toLocaleString("id-ID")}</span>
                </div>
                <div className="flex justify-between">
                  <span className="text-gray-600">Delivery</span>
                  <span className="font-medium">
                    {delivery === 0 ? (
                      <span className="text-green-600">Free</span>
                    ) : (
                      `Rp ${delivery.toLocaleString("id-ID")}`
                    )}
                  </span>
                </div>
                <div className="border-t pt-4">
                  <div className="flex justify-between">
                    <span className="text-lg font-semibold">Total</span>
                    <span className="text-xl font-bold text-orange-600">Rp {total.toLocaleString("id-ID")}</span>
                  </div>
                </div>
              </div>

              {/* Promo Code */}
              <div className="mb-6">
                <div className="flex space-x-2">
                  <input
                    type="text"
                    placeholder="Promo code"
                    className="flex-1 px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                  />
                  <button className="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                    Apply
                  </button>
                </div>
              </div>

              {/* Checkout Button */}
              <button
                onClick={handleCheckout}
                disabled={loading}
                className="w-full bg-orange-500 hover:bg-orange-600 disabled:bg-gray-300 text-white py-3 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center space-x-2"
              >
                {loading ? (
                  <>
                    <div className="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                    <span>Processing...</span>
                  </>
                ) : (
                  <>
                    <ShoppingBag className="w-5 h-5" />
                    <span>Proceed to Checkout</span>
                  </>
                )}
              </button>

              {/* Security Badge */}
              <div className="mt-4 text-center">
                <p className="text-xs text-gray-500">🔒 Secure checkout with SSL encryption</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* Toast Notifications */}
      {toast && <Toast message={toast.message} type={toast.type} onClose={() => setToast(null)} />}
    </div>
  )
}

export default Cart
