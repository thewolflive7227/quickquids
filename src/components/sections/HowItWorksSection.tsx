import { QrCode, WalletCards, Banknote } from "lucide-react";
import React from "react";

// Define the steps in an array for cleaner code
const steps = [
  {
    icon: <QrCode className="h-12 w-12 text-blue-600" />,
    title: "Step 1: Accept Payments Instantly",
    description:
      "Generate dynamic QR codes and accept payments from customers directly into your secure Quick-Quids wallet. No setup fees, no hassle.",
  },
  {
    icon: <WalletCards className="h-12 w-12 text-blue-600" />,
    title: "Step 2: Pay for All Your Utilities",
    description:
      "Use your wallet balance to pay for 28+ BBPS services. From electricity bills to loan repayments, manage all expenses from a single dashboard.",
  },
  {
    icon: <Banknote className="h-12 w-12 text-blue-600" />,
    title: "Step 3: Settle Funds to Your Bank",
    description:
      "Need funds in your bank account? Use our Instant Settlement feature to transfer your wallet balance to your registered bank account, 24x7.",
  },
];

const HowItWorksSection = () => {
  return (
    <section id="how-it-works" className="py-20 bg-gray-50">
      <div className="container">
        {/* Section Header */}
        <div className="text-center">
          <h2 className="text-3xl md:text-4xl font-extrabold text-gray-900">
            Get Started in 3 Simple Steps
          </h2>
          <p className="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
            Our streamlined process makes managing your business finances easier than ever.
          </p>
        </div>

        {/* Steps Grid */}
        <div className="mt-16 grid grid-cols-1 md:grid-cols-3 gap-12">
          {steps.map((step) => (
            <div key={step.title} className="text-center p-8 bg-white rounded-xl shadow-lg">
              <div className="flex justify-center items-center h-20">
                {step.icon}
              </div>
              <h3 className="mt-6 text-xl font-bold text-gray-900">{step.title}</h3>
              <p className="mt-2 text-base text-gray-600">{step.description}</p>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
};

export default HowItWorksSection;