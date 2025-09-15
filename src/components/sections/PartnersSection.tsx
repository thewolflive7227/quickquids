import Image from "next/image";
import React from "react";

// We'll define our partners here in an array for easy management
const partners = [
  { name: "Paytm", logo: "/logos/paytm.svg" },
  { name: "Fino Payments Bank", logo: "/logos/fino.svg" },
  { name: "Airtel Payments Bank", logo: "/logos/airtel.svg" },
  { name: "Axis Bank", logo: "/logos/axis.svg" },
  { name: "Yes Bank", logo: "/logos/yesbank.svg" },
  { name: "Bharat Connect", logo: "/logos/bharat-connect.svg" }, // Assuming a logo name
];

const PartnersSection = () => {
  return (
    <section className="py-12 bg-white">
      <div className="container">
        <h3 className="text-center text-sm font-semibold text-gray-500 tracking-wider uppercase">
          Our Trusted Banking & Technology Partners
        </h3>
        <div className="mt-8 flow-root">
          <div className="-mt-4 -ml-8 flex flex-wrap justify-center lg:-ml-4">
            {partners.map((partner) => (
              <div
                key={partner.name}
                className="mt-4 ml-8 flex flex-shrink-0 flex-grow justify-center lg:ml-4 lg:flex-grow-0"
              >
                <Image
                  className="h-12 w-auto object-contain grayscale hover:grayscale-0 transition-all duration-300"
                  src={partner.logo}
                  alt={partner.name}
                  width={158}
                  height={48}
                />
              </div>
            ))}
          </div>
        </div>
      </div>
    </section>
  );
};

export default PartnersSection;