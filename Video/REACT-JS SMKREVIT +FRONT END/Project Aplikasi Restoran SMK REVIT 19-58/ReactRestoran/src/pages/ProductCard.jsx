"use client"

import { useState } from "react"
import { Heart, Star, Plus, Eye, ShoppingCart } from "lucide-react"
import { useCart } from "../context/CartContext"

const ProductCard = ({ product, onQuickView, onToggleFavorite, isFavorite = false }) => {
  const [isHovered, setIsHovered] = useState(false)
  const [imageLoaded, setImageLoaded] = useState(false)
  const { addToCart } = useCart()

  const handleAddToCart = (e) => {
    e.stopPropagation()
    addToCart(product)
  }

  const handleQuickView = (e) => {
    e.stopPropagation()
    onQuickView(product)
  }

  const handleToggleFavorite = (e) => {
    e.stopPropagation()
    onToggleFavorite(product.idmenu)
  }

  return (
    <div
      className="group bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
      onMouseEnter={() => setIsHovered(true)}
      onMouseLeave={() => setIsHovered(false)}
    >
      {/* Image Container */}
      <div className="relative h-48 overflow-hidden bg-gray-100">
        {!imageLoaded && <div className="absolute inset-0 bg-gray-200 animate-pulse" />}
        <img
          src={`http://localhost:8000/${product.gambar}`}
          alt={product.menu}
          className={`w-full h-full object-cover transition-transform duration-300 group-hover:scale-110 ${
            imageLoaded ? "opacity-100" : "opacity-0"
          }`}
          onLoad={() => setImageLoaded(true)}
        />

        {/* Overlay Actions */}
        <div
          className={`absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center space-x-3 transition-opacity duration-300 ${
            isHovered ? "opacity-100" : "opacity-0"
          }`}
        >
          <button
            onClick={handleQuickView}
            className="bg-white text-gray-800 p-2 rounded-full hover:bg-gray-100 transition-colors duration-200"
          >
            <Eye className="w-4 h-4" />
          </button>
          <button
            onClick={handleAddToCart}
            className="bg-orange-500 text-white p-2 rounded-full hover:bg-orange-600 transition-colors duration-200"
          >
            <ShoppingCart className="w-4 h-4" />
          </button>
        </div>

        {/* Badges */}
        <div className="absolute top-3 left-3 flex flex-col space-y-2">
          {product.featured && (
            <span className="bg-orange-500 text-white text-xs px-2 py-1 rounded-full font-medium">Popular</span>
          )}
          {product.isNew && (
            <span className="bg-green-500 text-white text-xs px-2 py-1 rounded-full font-medium">New</span>
          )}
        </div>

        {/* Favorite Button */}
        <button
          onClick={handleToggleFavorite}
          className="absolute top-3 right-3 p-2 rounded-full bg-white bg-opacity-90 hover:bg-opacity-100 transition-all duration-200"
        >
          <Heart className={`w-4 h-4 ${isFavorite ? "fill-red-500 text-red-500" : "text-gray-600"}`} />
        </button>
      </div>

      {/* Content */}
      <div className="p-4">
        <div className="flex items-start justify-between mb-2">
          <h3 className="font-semibold text-gray-900 text-lg leading-tight group-hover:text-orange-600 transition-colors duration-200">
            {product.menu}
          </h3>
          <div className="flex items-center space-x-1 ml-2">
            <Star className="w-4 h-4 fill-yellow-400 text-yellow-400" />
            <span className="text-sm text-gray-600">4.5</span>
          </div>
        </div>

        <p className="text-gray-600 text-sm mb-3 line-clamp-2">
          {product.description || "Delicious and freshly prepared with the finest ingredients."}
        </p>

        <div className="flex items-center justify-between mb-3">
          <span className="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded-full">{product.kategori}</span>
          <div className="flex space-x-1">
            {/* Dietary Icons */}
            <span className="w-4 h-4 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-xs">
              V
            </span>
          </div>
        </div>

        <div className="flex items-center justify-between">
          <span className="text-xl font-bold text-gray-900">Rp {product.harga.toLocaleString("id-ID")}</span>
          <button
            onClick={handleAddToCart}
            className="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center space-x-2"
          >
            <Plus className="w-4 h-4" />
            <span>Add</span>
          </button>
        </div>
      </div>
    </div>
  )
}

export default ProductCard
