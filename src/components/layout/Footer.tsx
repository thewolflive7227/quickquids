import React from 'react';
import Link from 'next/link';
import Image from 'next/image';

const Footer = () => {
  return (
    <footer className="bg-gray-900 text-gray-400">
      <div className="container py-12">
        <div className="grid grid-cols-1 lg:grid-cols-4 gap-8">
          {/* About Section */}
          <div className="lg:col-span-1">
             <Link href="/" className="flex items-center mb-4">
              <Image src="/logo.png" alt="Quick-Quids Logo" width={40} height={40} />
              <span className="ml-2 text-xl font-bold text-white">Quick-Quids</span>
            </Link>
            <p className="text-sm">
              Your Professional Partner for Smart Business Payments. We empower businesses with seamless financial solutions.
            </p>
          </div>

          {/* Quick Links */}
          <div>
            <h3 className="text-sm font-semibold text-white tracking-wider uppercase">Quick Links</h3>
            <ul className="mt-4 space-y-2">
              <li><Link href="#services" className="text-sm hover:text-white transition-colors">Services</Link></li>
              <li><Link href="#how-it-works" className="text-sm hover:text-white transition-colors">How It Works</Link></li>
              <li><Link href="https://portal.quick-quids.com" target="_blank" className="text-sm hover:text-white transition-colors">Login</Link></li>
            </ul>
          </div>
          
           {/* Contact Info */}
          <div>
            <h3 className="text-sm font-semibold text-white tracking-wider uppercase">Contact Us</h3>
            <ul className="mt-4 space-y-2 text-sm">
              <li><a href="tel:+919408000012" className="hover:text-white transition-colors">+91 94080-00012</a></li>
              <li><a href="mailto:info@mybookingtechnologies.com" className="hover:text-white transition-colors">info@mybookingtechnologies.com</a></li>
              <li>Rajkot, Gujarat</li>
            </ul>
          </div>

        </div>
        <div className="mt-8 border-t border-gray-800 pt-8 text-sm text-center">
          <p>&copy; {new Date().getFullYear()} My Booking Technologies Pvt Ltd. All Rights Reserved.</p>
        </div>
      </div>
    </footer>
  );
};

export default Footer;