import React from 'react';

const Footer = () => {
  return (
    <footer className="bg-dark text-white py-3 mt-auto">
      <div className="container-fluid text-center">
        <p className="mb-0">© {new Date().getFullYear()} Aplikasi Restoran SMK REVIT. All rights reserved.</p>
      </div>
    </footer>
  );
};

export default Footer;