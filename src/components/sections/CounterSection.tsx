"use client";

import { motion, useMotionValue, useTransform, animate } from "framer-motion";
import { useInView } from "react-intersection-observer"; // <-- CORRECT IMPORT
import { useEffect, useRef } from "react";
import { Users, Map, Building } from "lucide-react";

const stats = [
  { value: 5000, suffix: "+", label: "Happy Retailers", icon: <Users className="h-10 w-10 text-white" /> },
  { value: 25, suffix: "+", label: "States Covered", icon: <Map className="h-10 w-10 text-white" /> },
  { value: 500, suffix: "+", label: "Cities Served", icon: <Building className="h-10 w-10 text-white" /> },
];

const Counter = ({ to, suffix }: { to: number; suffix: string }) => {
  const count = useMotionValue(0);
  const rounded = useTransform(count, (latest) => Math.round(latest));
  const displayText = useTransform(rounded, (latest) => latest.toLocaleString() + suffix);
  
  // This is how useInView should be used
  const { ref, inView } = useInView({ triggerOnce: true, threshold: 0.1 });

  useEffect(() => {
    if (inView) {
      const controls = animate(count, to, { duration: 2, ease: "easeOut" });
      return () => controls.stop();
    }
  }, [inView, count, to]);

  // We assign the ref to the motion.span
  return <motion.span ref={ref}>{displayText}</motion.span>;
};

const CounterSection = () => {
  return (
    <section className="bg-blue-600 text-white py-20">
      <div className="container">
        <div className="grid grid-cols-1 md:grid-cols-3 gap-12 text-center">
          {stats.map((stat) => (
            <div key={stat.label} className="flex flex-col items-center">
              <div className="mb-4">{stat.icon}</div>
              <div className="text-4xl md:text-5xl font-extrabold">
                <Counter to={stat.value} suffix={stat.suffix} />
              </div>
              <p className="mt-2 text-lg font-medium opacity-90">{stat.label}</p>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
};

export default CounterSection;