import React, { useState, useEffect } from 'react';
import { Link, useLocation, useNavigate } from 'react-router-dom';
import { getCurrentUser, setCurrentUser } from '../mockDb';
import { Moon, Sun, Menu, X } from 'lucide-react';

export default function Navbar() {
  const location = useLocation();
  const navigate = useNavigate();
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
  const [darkMode, setDarkMode] = useState(() => {
    return localStorage.getItem('color-theme') === 'dark' || 
      (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);
  });
  const [user, setUser] = useState(getCurrentUser());

  useEffect(() => {
    // Add custom event listener for user login/logout changes
    const handleUserChange = () => {
      setUser(getCurrentUser());
    };
    window.addEventListener('storage', handleUserChange);
    window.addEventListener('rk-user-changed', handleUserChange);
    return () => {
      window.removeEventListener('storage', handleUserChange);
      window.removeEventListener('rk-user-changed', handleUserChange);
    };
  }, []);

  useEffect(() => {
    if (darkMode) {
      document.documentElement.classList.add('dark');
      localStorage.setItem('color-theme', 'dark');
    } else {
      document.documentElement.classList.remove('dark');
      localStorage.setItem('color-theme', 'light');
    }
  }, [darkMode]);

  const handleLogout = () => {
    setCurrentUser(null);
    window.dispatchEvent(new Event('rk-user-changed'));
    navigate('/');
  };

  const menuItems = [
    { name: 'Beranda', path: '/' },
    { name: 'Puisi', path: '/poems' },
    { name: 'Penyair', path: '/writers' },
  ];

  const isActive = (path) => {
    if (path === '/') return location.pathname === '/';
    return location.pathname.startsWith(path);
  };

  return (
    <nav className="bg-white dark:bg-[#151515] border-b border-stone-100 dark:border-stone-800 shadow-sm sticky top-0 z-50 transition-colors duration-300">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex justify-between items-center h-20">
          {/* Logo */}
          <div className="flex-shrink-0 flex items-center">
            <Link to="/" className="font-serif text-xl font-bold tracking-wide text-[#1A1A1A] dark:text-[#EAEAEA] transition-opacity hover:opacity-80">
              RuangKata
            </Link>
          </div>

          {/* Desktop Menu */}
          <div className="hidden md:flex md:items-center md:space-x-8">
            {menuItems.map((item) => (
              <Link
                key={item.name}
                to={item.path}
                className={`group relative py-2 text-sm font-bold transition duration-300 ease-in-out ${
                  isActive(item.path)
                    ? 'text-[#8B5E3C] dark:text-[#C9A27C]'
                    : 'text-stone-600 dark:text-stone-400 hover:text-[#8B5E3C] dark:hover:text-[#C9A27C]'
                }`}
              >
                {item.name}
                <span
                  className={`absolute left-0 bottom-0 h-0.5 w-full bg-[#8B5E3C] dark:bg-[#C9A27C] transform transition-transform duration-300 ease-in-out ${
                    isActive(item.path) ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100'
                  }`}
                ></span>
              </Link>
            ))}

            {user ? (
              <>
                <Link
                  to="/dashboard"
                  className={`group relative py-2 text-sm font-bold transition duration-300 ease-in-out ${
                    location.pathname.startsWith('/dashboard') && !location.pathname.includes('/profile')
                      ? 'text-[#8B5E3C] dark:text-[#C9A27C]'
                      : 'text-stone-600 dark:text-stone-400 hover:text-[#8B5E3C] dark:hover:text-[#C9A27C]'
                  }`}
                >
                  Beranda Penyair
                  <span
                    className={`absolute left-0 bottom-0 h-0.5 w-full bg-[#8B5E3C] dark:bg-[#C9A27C] transform transition-transform duration-300 ease-in-out ${
                      location.pathname.startsWith('/dashboard') && !location.pathname.includes('/profile') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100'
                    }`}
                  ></span>
                </Link>
                <Link
                  to="/dashboard/profile"
                  className={`group relative py-2 text-sm font-bold transition duration-300 ease-in-out ${
                    location.pathname.includes('/profile')
                      ? 'text-[#8B5E3C] dark:text-[#C9A27C]'
                      : 'text-stone-600 dark:text-stone-400 hover:text-[#8B5E3C] dark:hover:text-[#C9A27C]'
                  }`}
                >
                  Profil
                  <span
                    className={`absolute left-0 bottom-0 h-0.5 w-full bg-[#8B5E3C] dark:bg-[#C9A27C] transform transition-transform duration-300 ease-in-out ${
                      location.pathname.includes('/profile') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100'
                    }`}
                  ></span>
                </Link>
                <button
                  onClick={handleLogout}
                  className="text-stone-600 dark:text-stone-400 hover:text-red-500 text-sm font-bold transition-colors cursor-pointer"
                >
                  Keluar
                </button>
              </>
            ) : (
              <Link
                to="/login"
                className="bg-[#8B5E3C] hover:bg-[#704B30] dark:bg-[#C9A27C] dark:hover:bg-[#DEB887] text-white dark:text-[#1A1A1A] px-6 py-2.5 rounded-full text-sm font-bold transition-all shadow-sm hover:shadow-md transform hover:-translate-y-0.5 tracking-wider uppercase text-[10px]"
              >
                Login
              </Link>
            )}

            {/* Theme Toggle */}
            <button
              onClick={() => setDarkMode(!darkMode)}
              type="button"
              className="ml-4 text-stone-500 dark:text-stone-400 hover:bg-stone-100 dark:hover:bg-[#202020] focus:outline-none rounded-full text-sm p-2 transition-colors cursor-pointer"
            >
              {darkMode ? <Sun className="w-5 h-5" /> : <Moon className="w-5 h-5" />}
            </button>
          </div>

          {/* Hamburger menu button */}
          <div className="-mr-2 flex items-center md:hidden">
            <button
              type="button"
              onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
              className="inline-flex items-center justify-center p-2 rounded-md text-stone-400 hover:text-stone-500 hover:bg-stone-100 dark:hover:bg-[#202020] focus:outline-none transition-colors"
            >
              <span className="sr-only">Open main menu</span>
              {mobileMenuOpen ? <X className="h-6 w-6" /> : <Menu className="h-6 w-6" />}
            </button>
          </div>
        </div>
      </div>

      {/* Mobile menu */}
      {mobileMenuOpen && (
        <div className="md:hidden">
          <div className="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white dark:bg-[#151515] border-t border-stone-100 dark:border-stone-800">
            {menuItems.map((item) => (
              <Link
                key={item.name}
                to={item.path}
                onClick={() => setMobileMenuOpen(false)}
                className={`block px-3 py-2 rounded-md text-base font-bold transition-colors ${
                  isActive(item.path)
                    ? 'text-[#8B5E3C] dark:text-[#C9A27C] bg-[#8B5E3C]/5 dark:bg-[#C9A27C]/5'
                    : 'text-stone-600 dark:text-stone-400 hover:text-[#8B5E3C] dark:hover:text-[#C9A27C] hover:bg-stone-50 dark:hover:bg-[#202020]'
                }`}
              >
                {item.name}
              </Link>
            ))}

            {user ? (
              <>
                <Link
                  to="/dashboard"
                  onClick={() => setMobileMenuOpen(false)}
                  className={`block px-3 py-2 rounded-md text-base font-bold transition-colors ${
                    location.pathname.startsWith('/dashboard') && !location.pathname.includes('/profile')
                      ? 'text-[#8B5E3C] dark:text-[#C9A27C] bg-[#8B5E3C]/5 dark:bg-[#C9A27C]/5'
                      : 'text-stone-600 dark:text-stone-400 hover:text-[#8B5E3C] dark:hover:text-[#C9A27C] hover:bg-stone-50 dark:hover:bg-[#202020]'
                  }`}
                >
                  Beranda Penyair
                </Link>
                <Link
                  to="/dashboard/profile"
                  onClick={() => setMobileMenuOpen(false)}
                  className={`block px-3 py-2 rounded-md text-base font-bold transition-colors ${
                    location.pathname.includes('/profile')
                      ? 'text-[#8B5E3C] dark:text-[#C9A27C] bg-[#8B5E3C]/5 dark:bg-[#C9A27C]/5'
                      : 'text-stone-600 dark:text-stone-400 hover:text-[#8B5E3C] dark:hover:text-[#C9A27C] hover:bg-stone-50 dark:hover:bg-[#202020]'
                  }`}
                >
                  Profil
                </Link>
                <button
                  onClick={() => {
                    handleLogout();
                    setMobileMenuOpen(false);
                  }}
                  className="block w-full text-left px-3 py-2 rounded-md text-base font-bold text-stone-600 dark:text-stone-400 hover:text-red-500 hover:bg-stone-50 dark:hover:bg-[#202020] cursor-pointer"
                >
                  Keluar
                </button>
              </>
            ) : (
              <Link
                to="/login"
                onClick={() => setMobileMenuOpen(false)}
                className="block px-3 py-2 mt-2 text-base font-bold text-center bg-[#8B5E3C] dark:bg-[#C9A27C] text-white dark:text-[#1A1A1A] rounded-md tracking-widest uppercase text-[10px]"
              >
                Login
              </Link>
            )}

            <div className="pt-4 pb-2 border-t border-stone-100 dark:border-stone-800 flex items-center justify-between px-3">
              <span className="text-sm font-bold text-stone-500">Mode Tampilan</span>
              <button
                type="button"
                onClick={() => setDarkMode(!darkMode)}
                className="text-stone-500 dark:text-stone-400 p-2 cursor-pointer"
              >
                {darkMode ? <Sun className="w-6 h-6" /> : <Moon className="w-6 h-6" />}
              </button>
            </div>
          </div>
        </div>
      )}
    </nav>
  );
}
