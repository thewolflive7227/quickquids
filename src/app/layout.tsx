import type { Metadata } from "next";
import { Inter } from "next/font/google";
import "./globals.css";
import Navbar from "@/components/layout/Navbar";
import Footer from "@/components/layout/Footer"; // <-- Import Footer

const inter = Inter({ subsets: ["latin"] });

export const metadata = {
  title: "Quick-Quids - Your Financial Hub",
  description: "Simplify Business Payments, Amplify Your Growth.",
};

export default function RootLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <html lang="en" className="!scroll-smooth">
      <body className={inter.className}>
        <Navbar />
        <main className="pt-16">{children}</main>
        <Footer /> {/* <-- Add Footer here */}
      </body>
    </html>
  );
}