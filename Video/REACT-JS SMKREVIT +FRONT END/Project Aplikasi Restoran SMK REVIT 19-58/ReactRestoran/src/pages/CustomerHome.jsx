"use client"

import { useState, useEffect } from "react"
import { Link } from "react-router-dom"
import { Star, Clock, Users, Award, ArrowRight, Play } from "lucide-react"
import axios from "axios"
import ProductCard from "./ProductCard"

const CustomerHome = () => {
  const [featuredMenus, setFeaturedMenus] = useState([])
  const [loading, setLoading] = useState(true)

  useEffect(() => {
    const fetchFeaturedMenus = async () => {
      try {
        const response = await axios.get("http://localhost:8000/api/menus")
        // Get first 6 items as featured
        setFeaturedMenus(response.data.data.slice(0, 6))
      } catch (error) {
        console.error("Error fetching featured menus:", error)
      } finally {
        setLoading(false)
      }
    }

    fetchFeaturedMenus()
  }, [])

  const stats = [
    { icon: Users, label: "Happy Customers", value: "10,000+" },
    { icon: Award, label: "Awards Won", value: "25+" },
    { icon: Star, label: "Average Rating", value: "4.9" },
    { icon: Clock, label: "Years Experience", value: "15+" },
  ]

  const testimonials = [
    {
      name: "Sarah Johnson",
      rating: 5,
      comment: "Amazing food and excellent service! The best restaurant experience I've had.",
      avatar: "/placeholder.svg?height=60&width=60",
    },
    {
      name: "Mike Chen",
      rating: 5,
      comment: "Fresh ingredients, authentic flavors, and quick delivery. Highly recommended!",
      avatar: "/placeholder.svg?height=60&width=60",
    },
    {
      name: "Emily Davis",
      rating: 5,
      comment: "The online ordering system is so easy to use. Food always arrives hot and delicious.",
      avatar: "/placeholder.svg?height=60&width=60",
    },
  ]

  return (
    <div className="min-h-screen bg-gray-50">      {/* Hero Section */}
      <section className="relative text-white overflow-hidden">
        {/* Background Image with Orange Overlay */}
        <div 
          className="absolute inset-0 bg-center bg-cover bg-no-repeat"
          style={{
            backgroundImage: 'url("/restaurant-kitchen.jpeg")',
          }}
        ></div>
        <div className="absolute inset-0 bg-gradient-to-r from-orange-600/90 to-orange-700/"></div>
        <div className="relative container mx-auto px-4 py-20 lg:py-32">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            <div className="space-y-8">
              <div className="space-y-4">
                <h1 className="text-4xl lg:text-6xl font-bold leading-tight">
                  Taste the
                  <span className="block text-yellow-300">Extraordinary</span>
                </h1>
                <p className="text-xl lg:text-2xl text-orange-100">
                  Experience culinary excellence with fresh ingredients and authentic flavors at SMK REVIT Restaurant
                </p>
              </div>

              <div className="flex flex-col sm:flex-row gap-4">
                <Link
                  to="/menu"
                  className="bg-white text-orange-600 px-8 py-4 rounded-full font-semibold text-lg hover:bg-orange-50 transition-colors duration-200 flex items-center justify-center space-x-2"
                >
                  <span>Order Now</span>
                  <ArrowRight className="w-5 h-5" />
                </Link>
                <button className="border-2 border-white text-white px-8 py-4 rounded-full font-semibold text-lg hover:bg-white hover:text-orange-600 transition-colors duration-200 flex items-center justify-center space-x-2">
                  <Play className="w-5 h-5" />
                  <span>Watch Video</span>
                </button>
              </div>

              {/* Stats */}
              <div className="grid grid-cols-2 lg:grid-cols-4 gap-6 pt-8">
                {stats.map((stat, index) => (
                  <div key={index} className="text-center">
                    <stat.icon className="w-8 h-8 mx-auto mb-2 text-yellow-300" />
                    <div className="text-2xl font-bold">{stat.value}</div>
                    <div className="text-orange-100 text-sm">{stat.label}</div>
                  </div>
                ))}
              </div>
            </div>

            <div className="relative">
              <div className="relative z-10">
                <img
                  src="../../public/burger.jpeg"
                  alt="Delicious Food"
                  style={{ height: "250px", width: "50%" }}
                  className="max-w-lg mx-auto rounded-2xl shadow-2xl"
                />
              </div>
              <div className="absolute top-25.5 -right-4 bg-yellow-400 text-orange-800 px-4 py-2 rounded-full font-semibold animate-bounce">
                Fresh Daily!
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Featured Menu Section */}
      <section className="py-20 bg-white">
        <div className="container mx-auto px-4">
          <div className="text-center mb-16">
            <h2 className="text-4xl font-bold text-gray-900 mb-4">Featured Menu</h2>
            <p className="text-xl text-gray-600 max-w-2xl mx-auto">
              Discover our most popular dishes, carefully crafted with the finest ingredients
            </p>
          </div>

          {loading ? (
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
              {[...Array(6)].map((_, index) => (
                <div key={index} className="animate-pulse">
                  <div className="bg-gray-200 h-48 rounded-xl mb-4"></div>
                  <div className="space-y-2">
                    <div className="bg-gray-200 h-4 rounded w-3/4"></div>
                    <div className="bg-gray-200 h-3 rounded w-1/2"></div>
                    <div className="bg-gray-200 h-6 rounded w-1/3"></div>
                  </div>
                </div>
              ))}
            </div>
          ) : (
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
              {featuredMenus.map((menu) => (
                <ProductCard
                  key={menu.idmenu}
                  product={{ ...menu, featured: true }}
                  onQuickView={() => {}}
                  onToggleFavorite={() => {}}
                />
              ))}
            </div>
          )}

          <div className="text-center mt-12">
            <Link
              to="/menu"
              className="bg-orange-500 hover:bg-orange-600 text-white px-8 py-4 rounded-full font-semibold text-lg transition-colors duration-200 inline-flex items-center space-x-2"
            >
              <span>View Full Menu</span>
              <ArrowRight className="w-5 h-5" />
            </Link>
          </div>
        </div>
      </section>

      {/* About Section */}
      <section className="py-20 bg-gray-50">
        <div className="container mx-auto px-4">
          <div className="grid lg:grid-cols-2 gap-16 items-center">
            <div className="space-y-8">
              <div className="space-y-4">
                <h2 className="text-4xl font-bold text-gray-900">Our Story of Culinary Excellence</h2>
                <p className="text-lg text-gray-600">
                  For over 15 years, SMK REVIT Restaurant has been serving authentic, delicious meals made with the
                  freshest ingredients. Our passion for culinary excellence drives us to create memorable dining
                  experiences for every customer.
                </p>
              </div>

              <div className="grid grid-cols-2 gap-6">
                <div className="text-center p-6 bg-white rounded-xl shadow-sm">
                  <div className="text-3xl font-bold text-orange-600 mb-2">15+</div>
                  <div className="text-gray-600">Years Experience</div>
                </div>
                <div className="text-center p-6 bg-white rounded-xl shadow-sm">
                  <div className="text-3xl font-bold text-orange-600 mb-2">50+</div>
                  <div className="text-gray-600">Menu Items</div>
                </div>
              </div>

              <Link
                to="/menu"
                className="inline-flex items-center space-x-2 text-orange-600 font-semibold hover:text-orange-700 transition-colors duration-200"
              >
                <span>Learn More About Us</span>
                <ArrowRight className="w-4 h-4" />
              </Link>
            </div>

            <div className="relative">
              <img
                src="../../public/people cooking.jpeg"
                alt="Restaurant Interior"
                className="w-full rounded-2xl shadow-xl"
              />
              <div className="absolute -bottom-6 -left-6 bg-orange-500 text-white p-6 rounded-xl shadow-lg">
                <div className="text-2xl font-bold">4.9★</div>
                <div className="text-orange-100">Customer Rating</div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Testimonials Section */}
      <section className="py-20 bg-white">
        <div className="container mx-auto px-4">
          <div className="text-center mb-16">
            <h2 className="text-4xl font-bold text-gray-900 mb-4">What Our Customers Say</h2>
            <p className="text-xl text-gray-600">Don't just take our word for it - hear from our satisfied customers</p>
          </div>

          <div className="grid md:grid-cols-3 gap-8">
            {testimonials.map((testimonial, index) => (
              <div key={index} className="bg-gray-50 p-8 rounded-2xl">
                <div className="flex items-center mb-4">
                  {[...Array(testimonial.rating)].map((_, i) => (
                    <Star key={i} className="w-5 h-5 fill-yellow-400 text-yellow-400" />
                  ))}
                </div>
                <p className="text-gray-600 mb-6 italic">"{testimonial.comment}"</p>
                <div className="flex items-center space-x-3">
                  <img
                    src={testimonial.avatar || "/placeholder.svg"}
                    alt={testimonial.name}
                    className="w-12 h-12 rounded-full object-cover"
                  />
                  <div>
                    <div className="font-semibold text-gray-900">{testimonial.name}</div>
                    <div className="text-sm text-gray-500">Verified Customer</div>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-20 bg-gradient-to-r from-orange-600 to-red-600 text-white">
        <div className="container mx-auto px-4 text-center">
          <div className="max-w-3xl mx-auto space-y-8">
            <h2 className="text-4xl lg:text-5xl font-bold">Ready to Experience Amazing Food?</h2>
            <p className="text-xl text-orange-100">
              Join thousands of satisfied customers and order your favorite meal today
            </p>
            <div className="flex flex-col sm:flex-row gap-4 justify-center">
              <Link
                to="/menu"
                className="bg-white text-orange-600 px-8 py-4 rounded-full font-semibold text-lg hover:bg-orange-50 transition-colors duration-200"
              >
                Order Now
              </Link>
              <Link
                to="/customer-register"
                className="border-2 border-white text-white px-8 py-4 rounded-full font-semibold text-lg hover:bg-white hover:text-orange-600 transition-colors duration-200"
              >
                Sign Up for Offers
              </Link>
            </div>
          </div>
        </div>
      </section>
    </div>
  )
}

export default CustomerHome
