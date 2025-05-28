"use client"

import { useState, useEffect } from "react"
import { useParams, useNavigate } from "react-router-dom"
import {
  ArrowLeft,
  Package,
  Truck,
  CheckCircle,
  Clock,
  MapPin,
  Phone,
  MessageCircle,
  Star,
  RefreshCw,
} from "lucide-react"
import axios from "axios"
import Toast from "./ui/toast"

const OrderTracking = () => {
  const { orderId } = useParams()
  const navigate = useNavigate()
  const [order, setOrder] = useState(null)
  const [loading, setLoading] = useState(true)
  const [error, setError] = useState(null)
  const [toast, setToast] = useState(null)

  useEffect(() => {
    fetchOrderDetails()
    // Set up polling for real-time updates
    const interval = setInterval(fetchOrderDetails, 30000) // Poll every 30 seconds
    return () => clearInterval(interval)
  }, [orderId])

  const fetchOrderDetails = async () => {
    try {
      const token = localStorage.getItem("token")
      const response = await axios.get(`http://localhost:8000/api/order-details/order/${orderId}`, {
        headers: {
          Authorization: `Bearer ${token}`,
          Accept: "application/json",
        },
      })

      if (response.data.status) {
        setOrder(response.data.order)
        setError(null)
      } else {
        setError("Order not found")
      }
    } catch (error) {
      console.error("Error fetching order details:", error)
      setError("Failed to load order details")
    } finally {
      setLoading(false)
    }
  }

  const getTrackingSteps = (status) => {
    const steps = [
      {
        id: 1,
        title: "Order Placed",
        description: "Your order has been received",
        icon: Package,
        completed: status >= 1,
        active: status === 1,
        time: order?.tglorder,
      },
      {
        id: 2,
        title: "Payment Confirmed",
        description: "Payment has been processed",
        icon: CheckCircle,
        completed: status >= 2,
        active: status === 2,
        time: order?.payment_time,
      },
      {
        id: 3,
        title: "Preparing Order",
        description: "Your food is being prepared",
        icon: Clock,
        completed: status >= 3,
        active: status === 3,
        time: order?.preparation_time,
      },
      {
        id: 4,
        title: "Out for Delivery",
        description: "Your order is on the way",
        icon: Truck,
        completed: status >= 4,
        active: status === 4,
        time: order?.delivery_time,
      },
      {
        id: 5,
        title: "Delivered",
        description: "Order has been delivered",
        icon: CheckCircle,
        completed: status >= 5,
        active: status === 5,
        time: order?.delivered_time,
      },
    ]

    return steps
  }

  const formatCurrency = (amount) => {
    return new Intl.NumberFormat("id-ID", {
      style: "currency",
      currency: "IDR",
      minimumFractionDigits: 0,
    }).format(amount)
  }

  const formatTime = (timeString) => {
    if (!timeString) return null
    return new Date(timeString).toLocaleTimeString("id-ID", {
      hour: "2-digit",
      minute: "2-digit",
    })
  }

  if (loading) {
    return (
      <div className="min-h-screen bg-gray-50 py-8">
        <div className="container mx-auto px-4">
          <div className="max-w-4xl mx-auto">
            <div className="animate-pulse space-y-6">
              <div className="h-8 bg-gray-200 rounded w-1/3"></div>
              <div className="bg-white rounded-xl p-6 space-y-4">
                <div className="h-6 bg-gray-200 rounded w-1/4"></div>
                <div className="h-4 bg-gray-200 rounded w-1/2"></div>
                <div className="h-32 bg-gray-200 rounded"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    )
  }

  if (error || !order) {
    return (
      <div className="min-h-screen bg-gray-50 py-8">
        <div className="container mx-auto px-4">
          <div className="max-w-md mx-auto text-center">
            <div className="bg-white rounded-xl shadow-sm p-8">
              <Package className="w-16 h-16 text-gray-300 mx-auto mb-4" />
              <h2 className="text-xl font-semibold text-gray-900 mb-2">Order Not Found</h2>
              <p className="text-gray-600 mb-6">{error}</p>
              <button
                onClick={() => navigate("/order-history")}
                className="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200"
              >
                Back to Orders
              </button>
            </div>
          </div>
        </div>
      </div>
    )
  }

  const trackingSteps = getTrackingSteps(order.status)
  const currentStep = trackingSteps.find((step) => step.active) || trackingSteps[0]

  return (
    <div className="min-h-screen bg-gray-50 py-8">
      <div className="container mx-auto px-4">
        <div className="max-w-4xl mx-auto">
          {/* Header */}
          <div className="flex items-center space-x-4 mb-8">
            <button
              onClick={() => navigate("/order-history")}
              className="p-2 hover:bg-white rounded-lg transition-colors duration-200"
            >
              <ArrowLeft className="w-5 h-5" />
            </button>
            <div>
              <h1 className="text-3xl font-bold text-gray-900">Track Order #{order.idorder}</h1>
              <p className="text-gray-600">Real-time updates on your order status</p>
            </div>
          </div>

          {/* Current Status Card */}
          <div className="bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-xl p-6 mb-8">
            <div className="flex items-center justify-between">
              <div>
                <h2 className="text-xl font-semibold mb-2">{currentStep.title}</h2>
                <p className="text-orange-100">{currentStep.description}</p>
                {currentStep.time && (
                  <p className="text-orange-100 text-sm mt-1">Updated at {formatTime(currentStep.time)}</p>
                )}
              </div>
              <div className="text-right">
                <currentStep.icon className="w-12 h-12 mb-2" />
                <button
                  onClick={fetchOrderDetails}
                  className="flex items-center space-x-1 text-orange-100 hover:text-white transition-colors duration-200"
                >
                  <RefreshCw className="w-4 h-4" />
                  <span className="text-sm">Refresh</span>
                </button>
              </div>
            </div>
          </div>

          <div className="grid lg:grid-cols-3 gap-8">
            {/* Tracking Timeline */}
            <div className="lg:col-span-2">
              <div className="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 className="text-lg font-semibold text-gray-900 mb-6">Order Progress</h3>

                <div className="space-y-6">
                  {trackingSteps.map((step, index) => {
                    const StepIcon = step.icon
                    return (
                      <div key={step.id} className="flex items-start space-x-4">
                        <div className="flex-shrink-0">
                          <div
                            className={`w-10 h-10 rounded-full flex items-center justify-center ${
                              step.completed
                                ? "bg-green-500 text-white"
                                : step.active
                                  ? "bg-orange-500 text-white"
                                  : "bg-gray-200 text-gray-400"
                            }`}
                          >
                            <StepIcon className="w-5 h-5" />
                          </div>
                          {index < trackingSteps.length - 1 && (
                            <div
                              className={`w-0.5 h-12 mx-auto mt-2 ${step.completed ? "bg-green-500" : "bg-gray-200"}`}
                            />
                          )}
                        </div>

                        <div className="flex-1 pb-8">
                          <h4
                            className={`font-medium ${
                              step.completed || step.active ? "text-gray-900" : "text-gray-500"
                            }`}
                          >
                            {step.title}
                          </h4>
                          <p className={`text-sm ${step.completed || step.active ? "text-gray-600" : "text-gray-400"}`}>
                            {step.description}
                          </p>
                          {step.time && <p className="text-xs text-gray-500 mt-1">{formatTime(step.time)}</p>}
                        </div>
                      </div>
                    )
                  })}
                </div>
              </div>

              {/* Delivery Information */}
              {order.status >= 4 && (
                <div className="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mt-6">
                  <h3 className="text-lg font-semibold text-gray-900 mb-4">Delivery Information</h3>

                  <div className="space-y-4">
                    <div className="flex items-start space-x-3">
                      <MapPin className="w-5 h-5 text-gray-400 mt-1" />
                      <div>
                        <p className="font-medium text-gray-900">Delivery Address</p>
                        <p className="text-gray-600">{order.pelanggan?.alamat || "Address not available"}</p>
                      </div>
                    </div>

                    <div className="flex items-center space-x-3">
                      <Phone className="w-5 h-5 text-gray-400" />
                      <div>
                        <p className="font-medium text-gray-900">Contact Number</p>
                        <p className="text-gray-600">{order.pelanggan?.telp || "Phone not available"}</p>
                      </div>
                    </div>
                  </div>

                  <div className="mt-6 pt-6 border-t border-gray-100">
                    <button className="w-full flex items-center justify-center space-x-2 bg-blue-500 text-white py-3 rounded-lg hover:bg-blue-600 transition-colors duration-200">
                      <MessageCircle className="w-4 h-4" />
                      <span>Contact Delivery Driver</span>
                    </button>
                  </div>
                </div>
              )}
            </div>

            {/* Order Summary */}
            <div className="space-y-6">
              {/* Order Details */}
              <div className="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 className="text-lg font-semibold text-gray-900 mb-4">Order Details</h3>

                <div className="space-y-3">
                  <div className="flex justify-between">
                    <span className="text-gray-600">Order ID</span>
                    <span className="font-medium">#{order.idorder}</span>
                  </div>
                  <div className="flex justify-between">
                    <span className="text-gray-600">Order Date</span>
                    <span className="font-medium">{new Date(order.tglorder).toLocaleDateString("id-ID")}</span>
                  </div>
                  <div className="flex justify-between">
                    <span className="text-gray-600">Total Amount</span>
                    <span className="font-bold text-orange-600">{formatCurrency(order.total)}</span>
                  </div>
                </div>
              </div>

              {/* Order Items */}
              <div className="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 className="text-lg font-semibold text-gray-900 mb-4">Items Ordered</h3>

                <div className="space-y-3">
                  {order.order_details?.map((detail) => (
                    <div key={detail.idorderdetail} className="flex items-center space-x-3">
                      <img
                        src={`http://localhost:8000/${detail.menu?.gambar || "placeholder.jpg"}`}
                        alt={detail.menu?.menu || "Unknown Item"}
                        className="w-12 h-12 object-cover rounded-lg"
                      />
                      <div className="flex-1">
                        <h4 className="font-medium text-gray-900 text-sm">{detail.menu?.menu || "Unknown Item"}</h4>
                        <p className="text-xs text-gray-600">Qty: {detail.jumlah}</p>
                      </div>
                      <span className="text-sm font-medium text-gray-900">
                        {formatCurrency(detail.jumlah * detail.hargajual)}
                      </span>
                    </div>
                  ))}
                </div>
              </div>

              {/* Rate Order (if completed) */}
              {order.status === 5 && (
                <div className="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                  <h3 className="text-lg font-semibold text-gray-900 mb-4">Rate Your Experience</h3>

                  <div className="text-center">
                    <div className="flex justify-center space-x-1 mb-4">
                      {[...Array(5)].map((_, i) => (
                        <Star key={i} className="w-6 h-6 text-gray-300 hover:text-yellow-400 cursor-pointer" />
                      ))}
                    </div>

                    <button className="w-full bg-orange-500 text-white py-3 rounded-lg hover:bg-orange-600 transition-colors duration-200">
                      Submit Rating
                    </button>
                  </div>
                </div>
              )}
            </div>
          </div>
        </div>
      </div>

      {/* Toast Notifications */}
      {toast && <Toast message={toast.message} type={toast.type} onClose={() => setToast(null)} />}
    </div>
  )
}

export default OrderTracking
