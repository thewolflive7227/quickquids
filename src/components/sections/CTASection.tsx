import { Button } from "@/components/ui/button";
import Link from "next/link";
import React from "react";

const CTASection = () => {
  return (
    <section id="contact" className="py-20 bg-white">
      <div className="container text-center">
        <h2 className="text-3xl md:text-4xl font-extrabold text-gray-900">
          Ready to Elevate Your Business?
        </h2>
        <p className="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
          Join thousands of retailers who trust Quick-Quids for seamless payments and business growth. Get started for free today!
        </p>
        <div className="mt-8">
          <Button size="lg" asChild className="bg-blue-600 hover:bg-blue-700">
            <Link href="https://portal.quick-quids.com/register">
              Register for Free
            </Link>
          </Button>
        </div>
      </div>
    </section>
  );
};

export default CTASection;