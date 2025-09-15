import { Button } from "@/components/ui/button";
import Image from "next/image";
import Link from "next/link";
import React from "react";

const Navbar = () => {
  return (
    <header className="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-sm border-b">
      <div className="container flex items-center justify-between h-16">
        {/* Logo */}
        <Link href="/" className="flex items-center">
          <Image
            src="/logo.png" // IMPORTANT: Make sure you have a logo file named 'quickquids.png' in the `public` folder
            alt="Quick-Quids Logo"
            width={40}
            height={40}
            className="h-10 w-auto"
          />
          <span className="ml-2 text-2xl font-bold text-gray-800">
          </span>
        </Link>

        {/* Navigation Links (Desktop) */}
        <nav className="hidden md:flex items-center gap-6 text-sm font-medium">
          <Link href="#services" className="text-gray-600 hover:text-primary transition-colors">
            Services
          </Link>
          <Link href="#how-it-works" className="text-gray-600 hover:text-primary transition-colors">
            How it Works
          </Link>
          <Link href="#contact" className="text-gray-600 hover:text-primary transition-colors">
            Contact
          </Link>
        </nav>

        {/* Login Button */}
        <div>
          <Button asChild>
            <a href="https://login.quick-quids.com" target="_blank" rel="noopener noreferrer">
              Login
            </a>
          </Button>
        </div>
      </div>
    </header>
  );
};

export default Navbar;