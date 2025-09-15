import {
  Signal, Tv, Users, CreditCard, HeartHandshake, SatelliteDish, ReceiptText,
  GraduationCap, Lightbulb, Car, Flame, Hospital, Building, ShieldCheck,
  Phone, Landmark, Cylinder, Smartphone, SmartphoneNfc, Trash2, FileText,
  Waypoints, TrendingUp, Gauge, Repeat, KeyRound, Clapperboard, Droplets,
} from "lucide-react";
import React from "react";

const services = [
  { icon: <Lightbulb size={32} className="text-blue-600" />, title: "Electricity", description: "Pay electricity bills for all major providers across India." },
  { icon: <Smartphone size={32} className="text-blue-600" />, title: "Mobile Postpaid", description: "Clear your postpaid mobile bills conveniently and instantly." },
  { icon: <SmartphoneNfc size={32} className="text-blue-600" />, title: "Mobile Prepaid", description: "Recharge any prepaid mobile number from any operator." },
  { icon: <SatelliteDish size={32} className="text-blue-600" />, title: "DTH", description: "Instantly recharge your DTH connection for uninterrupted entertainment." },
  { icon: <CreditCard size={32} className="text-blue-600" />, title: "Credit Card", description: "Pay your credit card bills securely and on time." },
  { icon: <Landmark size={32} className="text-blue-600" />, title: "Loan Repayment", description: "Easily pay your loan EMIs through our secure platform." },
  { icon: <GraduationCap size={32} className="text-blue-600" />, title: "Education Fees", description: "Pay school, college, or tuition fees in a hassle-free manner." },
  { icon: <Car size={32} className="text-blue-600" />, title: "Fastag", description: "Recharge your Fastag wallet instantly for smooth travels." },
  { icon: <Cylinder size={32} className="text-blue-600" />, title: "LPG Gas", description: "Book and pay for your LPG gas cylinder from any provider." },
  { icon: <Droplets size={32} className="text-blue-600" />, title: "Water", description: "Pay your water bills to municipal corporations and other boards." },
  { icon: <Signal size={32} className="text-blue-600" />, title: "Broadband Postpaid", description: "Settle your broadband and landline bills with ease." },
  { icon: <Building size={32} className="text-blue-600" />, title: "Housing Society", description: "Pay your monthly society maintenance and other charges." },
  { icon: <ShieldCheck size={32} className="text-blue-600" />, title: "Insurance", description: "Pay your life, health, or general insurance premiums here." },
  { icon: <Tv size={32} className="text-blue-600" />, title: "Cable TV", description: "Recharge your cable TV connection to keep the entertainment going." },
  { icon: <ReceiptText size={32} className="text-blue-600" />, title: "E-Challan", description: "Pay traffic e-challans issued by authorities in various states." },
  { icon: <HeartHandshake size={32} className="text-blue-600" />, title: "Donation", description: "Donate to registered NGOs and religious institutions." },
];

const ServicesSection = () => {
  return (
    <section id="services" className="py-20 bg-white">
      <div className="container">
        {/* Section Header */}
        <div className="text-center">
          <h2 className="text-3xl md:text-4xl font-extrabold text-gray-900">
            One-Stop Solution for All Utility Payments
          </h2>
          <p className="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
            From daily essentials to important financial commitments, manage all your payments through our comprehensive BBPS platform.
          </p>
        </div>

        {/* Services Grid */}
        <div className="mt-16 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
          {services.map((service) => (
            <div key={service.title} className="p-6 bg-white rounded-xl border border-gray-200 hover:shadow-xl hover:border-blue-500 transition-all duration-300">
              <div className="flex items-center gap-4">
                {service.icon}
                <h3 className="text-lg font-bold text-gray-900">{service.title}</h3>
              </div>
              <p className="mt-4 text-sm text-gray-600">{service.description}</p>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
};

export default ServicesSection;