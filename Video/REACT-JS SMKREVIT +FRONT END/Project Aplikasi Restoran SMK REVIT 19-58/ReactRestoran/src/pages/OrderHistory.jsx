"use client"

import { useState, useEffect } from "react"
import { useLocation, useNavigate } from "react-router-dom"
import {
  Search,
  Calendar,
  Clock,
  Package,
  CheckCircle,
  XCircle,
  RefreshCw,
  Eye,
  RotateCcw,
  Download,
  Star,
  ChevronDown,
  ChevronUp,
  Truck,
  CreditCard,
} from "lucide-react"
import axios from "axios"
import { useAuth } from "../context/AuthContext"
import { useCart } from "../context/CartContext"
import Toast from "./ui/toast"
import { LoadingSkeleton } from "./ui/loading-skeleton"

const OrderHistory = () => {
  const [orders, setOrders] = useState([])
  const [filteredOrders, setFilteredOrders] = useState([])
  const [loading, setLoading] = useState(true)
  const [error, setError] = useState(null)
  const [searchQuery, setSearchQuery] = useState("")
  const [statusFilter, setStatusFilter] = useState("all")
  const [dateFilter, setDateFilter] = useState("all")
  const [expandedOrder, setExpandedOrder] = useState(null)
  const [toast, setToast] = useState(null)
  const [reorderLoading, setReorderLoading] = useState(null)

  const { user } = useAuth()
  const { addToCart } = useCart()
  const location = useLocation()
  const navigate = useNavigate()

  useEffect(() => {
    fetchOrders()
  }, [user])

  useEffect(() => {
    filterOrders()
  }, [orders, searchQuery, statusFilter, dateFilter])

  const fetchOrders = async () => {
    try {
      setLoading(true)
      setError(null)

      if (!user?.id && !user?.idpelanggan) {
        setError("No user ID found. Please login again.")
        return
      }

      const token = localStorage.getItem("token")
      const response = await axios.get("http://localhost:8000/api/orders", {
        headers: {
          Authorization: `Bearer ${token}`,
          Accept: "application/json",
          "Content-Type": "application/json",
        },
        params: {
          idpelanggan: user.idpelanggan || user.id,
        },
      })

      if (response.data.status) {
        setOrders(response.data.data || [])
      } else {
        throw new Error(response.data.message || "Failed to load orders")
      }
    } catch (error) {
      console.error("Error fetching orders:", error)
      if (error.response?.status === 401) {
        setError("Session expired. Please login again.")
        setTimeout(() => navigate("/customer-login"), 2000)
      } else {
        setError(error.response?.data?.message || error.message || "Failed to load order history")
      }
    } finally {
      setLoading(false)
    }
  }

  const filterOrders = () => {
    let result = [...orders]

    // Search filter
    if (searchQuery.trim()) {
      const query = searchQuery.toLowerCase()
      result = result.filter(
        (order) =>
          order.idorder.toString().includes(query) ||
          order.order_details?.some((detail) => detail.menu?.menu.toLowerCase().includes(query)),
      )
    }

    // Status filter
    if (statusFilter !== "all") {
      result = result.filter((order) => {
        switch (statusFilter) {
          case "pending":
            return order.status === 0
          case "paid":
            return order.status === 1
          case "processing":
            return order.status === 2
          case "completed":
            return order.status === 3
          case "cancelled":
            return order.status === 4
          default:
            return true
        }
      })
    }

    // Date filter
    if (dateFilter !== "all") {
      const now = new Date()
      const filterDate = new Date()

      switch (dateFilter) {
        case "today":
          filterDate.setHours(0, 0, 0, 0)
          result = result.filter((order) => new Date(order.tglorder) >= filterDate)
          break
        case "week":
          filterDate.setDate(now.getDate() - 7)
          result = result.filter((order) => new Date(order.tglorder) >= filterDate)
          break
        case "month":
          filterDate.setMonth(now.getMonth() - 1)
          result = result.filter((order) => new Date(order.tglorder) >= filterDate)
          break
        case "3months":
          filterDate.setMonth(now.getMonth() - 3)
          result = result.filter((order) => new Date(order.tglorder) >= filterDate)
          break
      }
    }

    // Sort by date (newest first)
    result.sort((a, b) => new Date(b.tglorder) - new Date(a.tglorder))

    setFilteredOrders(result)
  }

  const getStatusConfig = (status) => {
    const configs = {
      0: {
        label: "Pending Payment",
        color: "bg-yellow-100 text-yellow-800",
        icon: Clock,
        progress: 25,
      },
      1: {
        label: "Paid",
        color: "bg-blue-100 text-blue-800",
        icon: CreditCard,
        progress: 50,
      },
      2: {
        label: "Processing",
        color: "bg-purple-100 text-purple-800",
        icon: Package,
        progress: 75,
      },
      3: {
        label: "Completed",
        color: "bg-green-100 text-green-800",
        icon: CheckCircle,
        progress: 100,
      },
      4: {
        label: "Cancelled",
        color: "bg-red-100 text-red-800",
        icon: XCircle,
        progress: 0,
      },
    }
    return configs[status] || configs[0]
  }

  const handleReorder = async (order) => {
    setReorderLoading(order.idorder)
    try {
      // Add all items from the order to cart
      order.order_details?.forEach((detail) => {
        if (detail.menu) {
          for (let i = 0; i < detail.jumlah; i++) {
            addToCart(detail.menu)
          }
        }
      })

      setToast({ message: "Items added to cart successfully!", type: "success" })
      setTimeout(() => navigate("/cart"), 1500)
    } catch (error) {
      setToast({ message: "Failed to add items to cart", type: "error" })
    } finally {
      setReorderLoading(null)
    }
  }

  const handleTrackOrder = (orderId) => {
    navigate(`/order-tracking/${orderId}`)
  }

  const formatCurrency = (amount) => {
    return new Intl.NumberFormat("id-ID", {
      style: "currency",
      currency: "IDR",
      minimumFractionDigits: 0,
    }).format(amount)
  }

  const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString("id-ID", {
      year: "numeric",
      month: "long",
      day: "numeric",
      hour: "2-digit",
      minute: "2-digit",
    })
  }

  if (loading) {
    return (
      <div className="min-h-screen bg-gray-50 py-8">
        <div className="container mx-auto px-4">
          <div className="mb-8">
            <LoadingSkeleton className="h-8 w-48 mb-2" />
            <LoadingSkeleton className="h-4 w-32" />
          </div>
          <div className="space-y-4">
            {[...Array(3)].map((_, index) => (
              <div key={index} className="bg-white rounded-xl p-6">
                <LoadingSkeleton className="h-6 w-32 mb-4" />
                <LoadingSkeleton className="h-4 w-full mb-2" />
                <LoadingSkeleton className="h-4 w-3/4 mb-4" />
                <LoadingSkeleton className="h-10 w-24" />
              </div>
            ))}
          </div>
        </div>
      </div>
    )
  }

  if (error) {
    return (
      <div className="min-h-screen bg-gray-50 py-8">
        <div className="container mx-auto px-4">
          <div className="max-w-md mx-auto text-center">
            <div className="bg-white rounded-xl shadow-sm p-8">
              <XCircle className="w-16 h-16 text-red-500 mx-auto mb-4" />
              <h2 className="text-xl font-semibold text-gray-900 mb-2">Error Loading Orders</h2>
              <p className="text-gray-600 mb-6">{error}</p>
              <button
                onClick={fetchOrders}
                className="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center space-x-2 mx-auto"
              >
                <RefreshCw className="w-4 h-4" />
                <span>Try Again</span>
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
        <div className="mb-8">
          <h1 className="text-3xl font-bold text-gray-900 mb-2">Order History</h1>
          <p className="text-gray-600">Track and manage your past orders</p>
        </div>

        {/* Success Message */}
        {location.state?.message && (
          <div className="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
            <div className="flex items-center space-x-2">
              <CheckCircle className="w-5 h-5 text-green-600" />
              <span className="text-green-800">{location.state.message}</span>
            </div>
          </div>
        )}

        {/* Filters */}
        <div className="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
          <div className="grid grid-cols-1 md:grid-cols-4 gap-4">
            {/* Search */}
            <div className="relative">
              <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-4 h-4" />
              <input
                type="text"
                placeholder="Search orders..."
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                className="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
              />
            </div>

            {/* Status Filter */}
            <select
              value={statusFilter}
              onChange={(e) => setStatusFilter(e.target.value)}
              className="px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
            >
              <option value="all">All Status</option>
              <option value="pending">Pending Payment</option>
              <option value="paid">Paid</option>
              <option value="processing">Processing</option>
              <option value="completed">Completed</option>
              <option value="cancelled">Cancelled</option>
            </select>

            {/* Date Filter */}
            <select
              value={dateFilter}
              onChange={(e) => setDateFilter(e.target.value)}
              className="px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
            >
              <option value="all">All Time</option>
              <option value="today">Today</option>
              <option value="week">Last 7 Days</option>
              <option value="month">Last Month</option>
              <option value="3months">Last 3 Months</option>
            </select>

            {/* Clear Filters */}
            <button
              onClick={() => {
                setSearchQuery("")
                setStatusFilter("all")
                setDateFilter("all")
              }}
              className="px-4 py-2 text-orange-600 border border-orange-600 rounded-lg hover:bg-orange-50 transition-colors duration-200"
            >
              Clear Filters
            </button>
          </div>
        </div>

        {/* Orders List */}
        {filteredOrders.length === 0 ? (
          <div className="text-center py-16">
            <div className="max-w-md mx-auto">
              <Package className="w-24 h-24 text-gray-300 mx-auto mb-6" />
              <h3 className="text-xl font-semibold text-gray-900 mb-2">No Orders Found</h3>
              <p className="text-gray-600 mb-6">
                {orders.length === 0 ? "You haven't placed any orders yet." : "No orders match your current filters."}
              </p>
              <button
                onClick={() => navigate("/menu")}
                className="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200"
              >
                Start Shopping
              </button>
            </div>
          </div>
        ) : (
          <div className="space-y-6">
            {filteredOrders.map((order) => {
              const statusConfig = getStatusConfig(order.status)
              const StatusIcon = statusConfig.icon
              const isExpanded = expandedOrder === order.idorder

              return (
                <div
                  key={order.idorder}
                  className="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden"
                >
                  {/* Order Header */}
                  <div className="p-6">
                    <div className="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                      <div className="flex-1">
                        <div className="flex items-center space-x-3 mb-2">
                          <h3 className="text-lg font-semibold text-gray-900">Order #{order.idorder}</h3>
                          <span
                            className={`inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${statusConfig.color}`}
                          >
                            <StatusIcon className="w-4 h-4 mr-1" />
                            {statusConfig.label}
                          </span>
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                          <div className="flex items-center space-x-2">
                            <Calendar className="w-4 h-4" />
                            <span>{formatDate(order.tglorder)}</span>
                          </div>
                          <div className="flex items-center space-x-2">
                            <Package className="w-4 h-4" />
                            <span>{order.order_details?.length || 0} items</span>
                          </div>
                          <div className="flex items-center space-x-2">
                            <CreditCard className="w-4 h-4" />
                            <span className="font-semibold text-gray-900">{formatCurrency(order.total)}</span>
                          </div>
                        </div>

                        {/* Progress Bar */}
                        <div className="mt-4">
                          <div className="flex justify-between text-xs text-gray-500 mb-1">
                            <span>Order Progress</span>
                            <span>{statusConfig.progress}%</span>
                          </div>
                          <div className="w-full bg-gray-200 rounded-full h-2">
                            <div
                              className="bg-gradient-to-r from-orange-500 to-red-500 h-2 rounded-full transition-all duration-300"
                              style={{ width: `${statusConfig.progress}%` }}
                            ></div>
                          </div>
                        </div>
                      </div>

                      {/* Action Buttons */}
                      <div className="flex flex-wrap gap-2">
                        <button
                          onClick={() => setExpandedOrder(isExpanded ? null : order.idorder)}
                          className="flex items-center space-x-2 px-4 py-2 text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200"
                        >
                          <Eye className="w-4 h-4" />
                          <span>Details</span>
                          {isExpanded ? <ChevronUp className="w-4 h-4" /> : <ChevronDown className="w-4 h-4" />}
                        </button>

                       

                        <button
                          onClick={() => handleReorder(order)}
                          disabled={reorderLoading === order.idorder}
                          className="flex items-center space-x-2 px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 disabled:bg-gray-300 transition-colors duration-200"
                        >
                          {reorderLoading === order.idorder ? (
                            <RefreshCw className="w-4 h-4 animate-spin" />
                          ) : (
                            <RotateCcw className="w-4 h-4" />
                          )}
                          <span>Reorder</span>
                        </button>
                      </div>
                    </div>
                  </div>

                  {/* Expanded Order Details */}
                  {isExpanded && (
                    <div className="border-t border-gray-100 p-6 bg-gray-50">
                      <div className="grid lg:grid-cols-2 gap-8">
                        {/* Order Items */}
                        <div>
                          <h4 className="font-semibold text-gray-900 mb-4">Order Items</h4>
                          <div className="space-y-3">
                            {order.order_details?.map((detail) => (
                              <div
                                key={detail.idorderdetail}
                                className="flex items-center space-x-3 bg-white p-3 rounded-lg"
                              >
                                <img
                                  src={`http://localhost:8000/${detail.menu?.gambar || "placeholder.jpg"}`}
                                  alt={detail.menu?.menu || "Unknown Item"}
                                  className="w-12 h-12 object-cover rounded-lg"
                                />
                                <div className="flex-1">
                                  <h5 className="font-medium text-gray-900">{detail.menu?.menu || "Unknown Item"}</h5>
                                  <p className="text-sm text-gray-600">
                                    Qty: {detail.jumlah} × {formatCurrency(detail.hargajual)}
                                  </p>
                                </div>
                                <div className="text-right">
                                  <p className="font-semibold text-gray-900">
                                    {formatCurrency(detail.jumlah * detail.hargajual)}
                                  </p>
                                </div>
                              </div>
                            ))}
                          </div>
                        </div>

                        {/* Order Summary */}
                        <div>
                          <h4 className="font-semibold text-gray-900 mb-4">Order Summary</h4>
                          <div className="bg-white p-4 rounded-lg space-y-3">
                            <div className="flex justify-between">
                              <span className="text-gray-600">Subtotal</span>
                              <span className="font-medium">{formatCurrency(order.total)}</span>
                            </div>
                            <div className="flex justify-between">
                              <span className="text-gray-600">Tax (10%)</span>
                              <span className="font-medium">{formatCurrency(order.total * 0.1)}</span>
                            </div>
                            <div className="flex justify-between">
                              <span className="text-gray-600">Delivery</span>
                              <span className="font-medium text-green-600">Free</span>
                            </div>
                            <div className="border-t pt-3">
                              <div className="flex justify-between">
                                <span className="font-semibold text-gray-900">Total</span>
                                <span className="font-bold text-lg text-orange-600">{formatCurrency(order.total)}</span>
                              </div>
                            </div>

                            {order.status === 3 && (
                              <>
                                <div className="border-t pt-3">
                                  <div className="flex justify-between">
                                    <span className="text-gray-600">Paid</span>
                                    <span className="font-medium">{formatCurrency(order.bayar)}</span>
                                  </div>
                                  <div className="flex justify-between">
                                    <span className="text-gray-600">Change</span>
                                    <span className="font-medium">{formatCurrency(order.kembali)}</span>
                                  </div>
                                </div>
                              </>
                            )}
                          </div>

                          {/* Additional Actions */}
                          <div className="mt-4 space-y-2">
                            <button className="w-full flex items-center justify-center space-x-2 px-4 py-2 text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                              <Download className="w-4 h-4" />
                              <span>Download Receipt</span>
                            </button>

                            {order.status === 3 && (
                              <button className="w-full flex items-center justify-center space-x-2 px-4 py-2 text-orange-600 border border-orange-200 rounded-lg hover:bg-orange-50 transition-colors duration-200">
                                <Star className="w-4 h-4" />
                                <span>Rate & Review</span>
                              </button>
                            )}
                          </div>
                        </div>
                      </div>
                    </div>
                  )}
                </div>
              )
            })}
          </div>
        )}

        {/* Load More Button */}
        {filteredOrders.length > 0 && filteredOrders.length >= 10 && (
          <div className="text-center mt-8">
            <button className="bg-white text-gray-700 border border-gray-200 px-6 py-3 rounded-lg hover:bg-gray-50 transition-colors duration-200">
              Load More Orders
            </button>
          </div>
        )}
      </div>

      {/* Toast Notifications */}
      {toast && <Toast message={toast.message} type={toast.type} onClose={() => setToast(null)} />}
    </div>
  )
}

export default OrderHistory
