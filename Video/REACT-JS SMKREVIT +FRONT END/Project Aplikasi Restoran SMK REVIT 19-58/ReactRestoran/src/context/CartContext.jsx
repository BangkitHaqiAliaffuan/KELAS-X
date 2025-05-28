import React, { createContext, useContext, useState, useEffect } from 'react';

const CartContext = createContext();

export const useCart = () => {
  const context = useContext(CartContext);
  if (!context) {
    throw new Error('useCart must be used within a CartProvider');
  }
  return context;
};

export const CartProvider = ({ children }) => {
  const [cartItems, setCartItems] = useState(() => {
    const savedCart = localStorage.getItem('cart');
    return savedCart ? JSON.parse(savedCart) : [];
  });

  useEffect(() => {
    localStorage.setItem('cart', JSON.stringify(cartItems));
  }, [cartItems]);

  const addToCart = (menu) => {
    setCartItems(prevItems => {
      const existingItem = prevItems.find(item => item.idmenu === menu.idmenu);
      if (existingItem) {
        return prevItems.map(item =>
          item.idmenu === menu.idmenu
            ? { ...item, quantity: item.quantity + 1 }
            : item
        );
      }
      return [...prevItems, { ...menu, quantity: 1 }];
    });
  };

  const removeFromCart = (menuId) => {
    setCartItems(prevItems => prevItems.filter(item => item.idmenu !== menuId));
  };

  const updateQuantity = (menuId, quantity) => {
    if (quantity < 1) {
      removeFromCart(menuId);
      return;
    }
    setCartItems(prevItems =>
      prevItems.map(item =>
        item.idmenu === menuId ? { ...item, quantity } : item
      )
    );
  };

  const clearCart = () => {
    setCartItems([]);
  };

  const getCartTotal = () => {
    return cartItems.reduce((total, item) => total + (item.harga * item.quantity), 0);
  };

  return (
    <CartContext.Provider value={{
      cartItems,
      addToCart,
      removeFromCart,
      updateQuantity,
      clearCart,
      getCartTotal
    }}>
      {children}
    </CartContext.Provider>
  );
};