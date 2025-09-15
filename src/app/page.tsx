import CounterSection from "@/components/sections/CounterSection";
import CTASection from "@/components/sections/CTASection";
import HeroSection from "@/components/sections/HeroSection";
import HowItWorksSection from "@/components/sections/HowItWorksSection";
import MobileAppSection from "@/components/sections/MobileAppSection";
import PartnersSection from "@/components/sections/PartnersSection";
import ServicesSection from "@/components/sections/ServicesSection";

export default function Home() {
  return (
    <>
      <HeroSection />
      <PartnersSection />
      <HowItWorksSection />
      <ServicesSection />
      <MobileAppSection />
      <CounterSection />
      <CTASection />
    </>
  );
}