import React from 'react';
import { Link } from 'react-router-dom';

export default function Footer() {
  return (
    <footer className="bg-white dark:bg-[#111] border-t border-stone-100 dark:border-stone-800 py-12 transition-colors duration-300">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex flex-col md:flex-row justify-between items-center gap-6">
          <div className="flex items-center space-x-3">
            <span className="font-serif text-lg font-bold text-[#8B5E3C] dark:text-[#C9A27C]">RuangKata</span>
            <span className="text-stone-300 dark:text-stone-700">|</span>
            <p className="text-xs text-stone-500 dark:text-stone-400">
              &copy; {new Date().getFullYear()} RuangKata. Semua hak cipta dilindungi.
            </p>
          </div>

          <div className="flex space-x-8 text-xs font-bold text-stone-500 dark:text-stone-400">
            <Link to="/" className="hover:text-[#8B5E3C] dark:hover:text-[#C9A27C] transition-colors">Beranda</Link>
            <Link to="/poems" className="hover:text-[#8B5E3C] dark:hover:text-[#C9A27C] transition-colors">Puisi</Link>
            <Link to="/writers" className="hover:text-[#8B5E3C] dark:hover:text-[#C9A27C] transition-colors">Penyair</Link>
          </div>
        </div>
      </div>
    </footer>
  );
}
