"use client"; // This is required for animations and hooks

import Image from "next/image";
import React, { useEffect } from "react";
import { motion, useAnimation } from "framer-motion";
import { useInView } from "react-intersection-observer";
import { CheckCircle } from "lucide-react";

const features = [
  { icon: <CheckCircle className="h-6 w-6 text-blue-600" />, text: "Instant and Easy Onboarding" },
  { icon: <CheckCircle className="h-6 w-6 text-blue-600" />, text: "Highly Safe & Secure App" },
  { icon: <CheckCircle className="h-6 w-6 text-blue-600" />, text: "24/7 Wallet Top-up Facility" },
  { icon: <CheckCircle className="h-6 w-6 text-blue-600" />, text: "All BBPS Services in One App" },
];

const MobileAppSection = () => {
  const controls = useAnimation();
  const [ref, inView] = useInView({
    triggerOnce: true, // Only trigger the animation once
    threshold: 0.3,   // Trigger when 30% of the section is visible
  });

  useEffect(() => {
    if (inView) {
      controls.start("visible");
    }
  }, [controls, inView]);

  return (
    <section className="py-20 bg-gray-50 overflow-hidden"> {/* overflow-hidden is important for animations */}
      <div className="container">
        <div ref={ref} className="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
          
          {/* Left Column: Mobile App Image (Animated) */}
          <motion.div
            initial={{ opacity: 0, x: -100 }}
            animate={controls}
            variants={{
              visible: { opacity: 1, x: 0, transition: { duration: 0.8, ease: "easeOut" } },
            }}
            className="flex justify-center"
          >
            <Image
              src="/mobile-app.png" // IMPORTANT: Place your transparent PNG here
              alt="Quick-Quids Mobile App"
              width={450}
              height={900}
              className="w-[450px] h-auto"
            />
          </motion.div>

          {/* Right Column: Text Content (Animated) */}
          <motion.div
            initial={{ opacity: 0, x: 100 }}
            animate={controls}
            variants={{
              visible: { opacity: 1, x: 0, transition: { duration: 0.8, ease: "easeOut" } },
            }}
          >
            <h2 className="text-3xl md:text-4xl font-extrabold text-gray-900">
              The Power of Quick-Quids, In Your Pocket
            </h2>
            <p className="mt-4 text-lg text-gray-600">
              Manage collections, expenses, bill payments, and transfers on the go. Our user-friendly app brings all the power of Quick-Quids to your fingertips.
            </p>
            <ul className="mt-8 space-y-4">
              {features.map((feature, index) => (
                <li key={index} className="flex items-center gap-3">
                  {feature.icon}
                  <span className="text-base font-medium text-gray-700">{feature.text}</span>
                </li>
              ))}
            </ul>
          </motion.div>

        </div>
      </div>
    </section>
  );
};

export default MobileAppSection;