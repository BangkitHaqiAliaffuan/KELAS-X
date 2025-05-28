"use client"

import { useState } from "react"
import { Link, useLocation } from "react-router-dom"
import { Menu, X, ShoppingCart, User, Heart, Search, Home } from "lucide-react"
import { useAuth } from "../context/AuthContext"
import { useCart } from "../context/CartContext"
import CartPreview from "../pages/CartPreview"

const CustomerNavbar = () => {
  const [isMenuOpen, setIsMenuOpen] = useState(false)
  const [isCartOpen, setIsCartOpen] = useState(false)
  const { user, logout, isAuthenticated } = useAuth()
  const { cartItems } = useCart()
  const location = useLocation()

  const totalItems = cartItems.reduce((sum, item) => sum + item.quantity, 0)

  const handleLogout = () => {
    logout()
    setIsMenuOpen(false)
  }

  const navLinks = [
    { to: "/", label: "Home", icon: Home },
    { to: "/menu", label: "Menu", icon: null },
    { to: "/order-history", label: "Orders", icon: null, authRequired: true },
  ]

  const isActivePath = (path) => {
    if (path === "/" && location.pathname === "/") return true
    if (path !== "/" && location.pathname.startsWith(path)) return true
    return false
  }

  return (
    <>
      <nav className="bg-white shadow-lg sticky top-0 z-40">
        <div className="container mx-auto px-4">
          <div className="flex justify-between items-center h-16">
            {/* Logo */}
            <Link to="/" className="flex items-center space-x-2">
              <div className="w-10 h-10 bg-gradient-to-r from-orange-500 to-red-500 rounded-lg flex items-center justify-center">
                <span className="text-white font-bold text-lg">R</span>
              </div>
              <span className="text-xl font-bold text-gray-900 hidden sm:block">SMK REVIT Restaurant</span>
            </Link>

            {/* Desktop Navigation */}
            <div className="hidden md:flex items-center space-x-8">
              {navLinks.map((link) => {
                if (link.authRequired && !isAuthenticated) return null
                return (
                  <Link
                    key={link.to}
                    to={link.to}
                    className={`font-medium transition-colors duration-200 ${
                      isActivePath(link.to) ? "text-orange-600" : "text-gray-700 hover:text-orange-600"
                    }`}
                  >
                    {link.label}
                  </Link>
                )
              })}
            </div>

            {/* Desktop Actions */}
            <div className="hidden md:flex items-center space-x-4">
              {/* Search */}
              <button className="p-2 text-gray-600 hover:text-orange-600 transition-colors duration-200">
                <Search className="w-5 h-5" />
              </button>

              {/* Favorites */}
              {isAuthenticated && (
                <button className="p-2 text-gray-600 hover:text-orange-600 transition-colors duration-200">
                  <Heart className="w-5 h-5" />
                </button>
              )}

              {/* Cart */}
              <button
                onClick={() => setIsCartOpen(true)}
                className="relative p-2 text-gray-600 hover:text-orange-600 transition-colors duration-200"
              >
                <ShoppingCart className="w-5 h-5" />
                {totalItems > 0 && (
                  <span className="absolute -top-1 -right-1 bg-orange-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                    {totalItems}
                  </span>
                )}
              </button>

              {/* User Menu */}
              {isAuthenticated ? (
                <div className="flex items-center space-x-3">
                  <div className="flex items-center space-x-2">
                    <div className="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center">
                      <User className="w-4 h-4 text-white" />
                    </div>
                    <span className="text-sm font-medium text-gray-700">{user.pelanggan || user.email}</span>
                  </div>
                  <button
                    onClick={handleLogout}
                    className="text-sm text-gray-600 hover:text-orange-600 transition-colors duration-200"
                  >
                    Logout
                  </button>
                </div>
              ) : (
                <div className="flex items-center space-x-3">
                  <Link
                    to="/customer-login"
                    className="text-gray-700 hover:text-orange-600 font-medium transition-colors duration-200"
                  >
                    Login
                  </Link>
                  <Link
                    to="/customer-register"
                    className="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200"
                  >
                    Sign Up
                  </Link>
                </div>
              )}
            </div>

            {/* Mobile Menu Button */}
            <button
              onClick={() => setIsMenuOpen(!isMenuOpen)}
              className="md:hidden p-2 text-gray-600 hover:text-orange-600 transition-colors duration-200"
            >
              {isMenuOpen ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
            </button>
          </div>

          {/* Mobile Menu */}
          <div
            className={`md:hidden transition-all duration-300 overflow-hidden ${
              isMenuOpen ? "max-h-96 pb-4" : "max-h-0"
            }`}
          >
            <div className="space-y-2 pt-4 border-t">
              {navLinks.map((link) => {
                if (link.authRequired && !isAuthenticated) return null
                return (
                  <Link
                    key={link.to}
                    to={link.to}
                    onClick={() => setIsMenuOpen(false)}
                    className={`block px-4 py-2 rounded-lg font-medium transition-colors duration-200 ${
                      isActivePath(link.to) ? "bg-orange-50 text-orange-600" : "text-gray-700 hover:bg-gray-50"
                    }`}
                  >
                    {link.label}
                  </Link>
                )
              })}

              {/* Mobile Cart */}
              <button
                onClick={() => {
                  setIsCartOpen(true)
                  setIsMenuOpen(false)
                }}
                className="flex items-center justify-between w-full px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-lg"
              >
                <span>Cart</span>
                <div className="flex items-center space-x-2">
                  <ShoppingCart className="w-4 h-4" />
                  {totalItems > 0 && (
                    <span className="bg-orange-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                      {totalItems}
                    </span>
                  )}
                </div>
              </button>

              {/* Mobile Auth */}
              {isAuthenticated ? (
                <div className="px-4 py-2 border-t mt-2 pt-4">
                  <div className="flex items-center space-x-2 mb-3">
                    <div className="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center">
                      <User className="w-4 h-4 text-white" />
                    </div>
                    <span className="font-medium text-gray-700">{user.pelanggan || user.email}</span>
                  </div>
                  <button onClick={handleLogout} className="text-red-600 hover:text-red-700 font-medium">
                    Logout
                  </button>
                </div>
              ) : (
                <div className="px-4 py-2 border-t mt-2 pt-4 space-y-2">
                  <Link
                    to="/customer-login"
                    onClick={() => setIsMenuOpen(false)}
                    className="block w-full text-center border border-orange-500 text-orange-600 py-2 rounded-lg font-medium hover:bg-orange-50 transition-colors duration-200"
                  >
                    Login
                  </Link>
                  <Link
                    to="/customer-register"
                    onClick={() => setIsMenuOpen(false)}
                    className="block w-full text-center bg-orange-500 text-white py-2 rounded-lg font-medium hover:bg-orange-600 transition-colors duration-200"
                  >
                    Sign Up
                  </Link>
                </div>
              )}
            </div>
          </div>
        </div>
      </nav>

      {/* Cart Preview */}
      <CartPreview isOpen={isCartOpen} onClose={() => setIsCartOpen(false)} />
    </>
  )
}

export default CustomerNavbar
