import { Button } from "@/components/ui/button";
import Image from "next/image";
import Link from "next/link";
import React from "react";

const HeroSection = () => {
  return (
    <section className="bg-gray-50">
      <div className="container py-20 sm:py-24 lg:py-32">
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
          {/* Left Column: Text Content & Buttons */}
          <div className="text-center lg:text-left">
            <h1 className="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 tracking-tight">
              Simplify Business Payments,
              <br />
              <span className="text-blue-600">Amplify Your Growth.</span>
            </h1>
            <p className="mt-6 text-lg text-gray-600 max-w-xl mx-auto lg:mx-0">
              Effortlessly manage QR collections, instant settlements, and all your BBPS needs from a single, powerful platform. Free registration, 24x7 support.
            </p>
            <div className="mt-8 flex justify-center lg:justify-start gap-4">
              <Button size="lg" asChild>
                <Link href="#services">Explore Services</Link>
              </Button>
              <Button size="lg" variant="outline" asChild>
                <Link href="#contact">Contact Us</Link>
              </Button>
            </div>
          </div>

          {/* Right Column: Image */}
          <div className="flex justify-center">
            <Image
              src="/hero-banner.jpeg" // IMPORTANT: Make sure you have this image in the `public` folder
              alt="Quick-Quids Financial Hub"
              width={600}
              height={500}
              className="rounded-lg shadow-2xl object-cover"
              priority // This tells Next.js to load this image first
            />
          </div>
        </div>
      </div>
    </section>
  );
};

export default HeroSection;