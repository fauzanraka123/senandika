import React, { useState, useEffect } from 'react';
import { useNavigate, Link } from 'react-router-dom';
import { loginUser, getUsers } from '../mockDb';
import { CornerUpLeft, UserPlus, ArrowRight, AlertCircle, Info } from 'lucide-react';

export default function Login() {
  const navigate = useNavigate();
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState('');

  // Environment variable for real Google Login
  const googleClientId = import.meta.env.VITE_GOOGLE_CLIENT_ID;
  const isGoogleConfigured = googleClientId && googleClientId !== 'your_google_client_id_here' && googleClientId !== '';

  // Custom Google OAuth Mock State (for when client ID is not configured)
  const [showGoogleModal, setShowGoogleModal] = useState(false);
  const [googleStep, setGoogleStep] = useState('chooser'); // 'chooser', 'custom', 'loading'
  const [googleCustomName, setGoogleCustomName] = useState('');
  const [googleCustomEmail, setGoogleCustomEmail] = useState('');
  const [googleCustomError, setGoogleCustomError] = useState('');
  const [loadingAccountName, setLoadingAccountName] = useState('');
  const [loadingAccountEmail, setLoadingAccountEmail] = useState('');

  // 1. Real Google Login Integration (using official Google Identity Services)
  useEffect(() => {
    if (!isGoogleConfigured) return;

    const initializeGoogleSignIn = () => {
      if (window.google && window.google.accounts) {
        try {
          window.google.accounts.id.initialize({
            client_id: googleClientId,
            callback: handleCredentialResponse,
            auto_select: false,
          });

          // Render native Google Button
          const isDark = document.documentElement.classList.contains('dark');
          window.google.accounts.id.renderButton(
            document.getElementById("googleBtnParent"),
            {
              theme: isDark ? "filled_black" : "outline",
              size: "large",
              width: "100%",
              shape: "pill",
              text: "signin_with",
            }
          );
        } catch (err) {
          console.error("Error initializing Google Sign-In:", err);
          setError("Gagal memuat tombol Google Login. Periksa Client ID Anda.");
        }
      }
    };

    // Polling script load in case accounts.google.com/gsi/client is still loading
    if (window.google) {
      initializeGoogleSignIn();
    } else {
      const interval = setInterval(() => {
        if (window.google) {
          initializeGoogleSignIn();
          clearInterval(interval);
        }
      }, 100);
      return () => clearInterval(interval);
    }
  }, [isGoogleConfigured, googleClientId]);

  // Decode Google JWT Token and process login
  const handleCredentialResponse = (response) => {
    try {
      const jwtToken = response.credential;
      const payload = parseJwt(jwtToken);

      if (payload && payload.email) {
        const { name, email, picture } = payload;
        
        // Login or register user with real Google profile details!
        const user = loginUser(email, 'google_oauth_no_password');
        if (user) {
          // Synchronize profile details in mock database with real Google data
          const users = JSON.parse(localStorage.getItem('rk_users') || '[]');
          const idx = users.findIndex(u => u.email.toLowerCase() === email.toLowerCase());
          if (idx > -1) {
            users[idx].name = name || users[idx].name;
            users[idx].avatar = picture || users[idx].avatar;
            localStorage.setItem('rk_users', JSON.stringify(users));
            // Update currently logged in session details
            localStorage.setItem('rk_current_user', JSON.stringify(users[idx]));
          }

          window.dispatchEvent(new Event('rk-user-changed'));
          navigate('/dashboard');
        }
      } else {
        setError('Otentikasi Google gagal. Profil Google tidak mengandung alamat email.');
      }
    } catch (err) {
      console.error("Failed to login with Google credential:", err);
      setError('Gagal memverifikasi akun Google Anda. Silakan coba lagi.');
    }
  };

  // Helper to decode base64 JWT payload safely supporting unicode characters
  const parseJwt = (token) => {
    try {
      const base64Url = token.split('.')[1];
      const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
      const jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
      }).join(''));
      return JSON.parse(jsonPayload);
    } catch (e) {
      console.error("Failed to parse Google JWT token", e);
      return null;
    }
  };

  // 2. Normal email / password login
  const handleLogin = (e) => {
    e.preventDefault();
    if (!email) {
      setError('Email wajib diisi.');
      return;
    }
    
    const user = loginUser(email, password || 'password');
    if (user) {
      window.dispatchEvent(new Event('rk-user-changed'));
      navigate('/dashboard');
    } else {
      setError('Gagal masuk. Silakan periksa kembali.');
    }
  };

  // Interactive Mock Google Login Click (runs when Client ID is not configured)
  const handleGoogleLoginClick = () => {
    setGoogleStep('chooser');
    setGoogleCustomName('');
    setGoogleCustomEmail('');
    setGoogleCustomError('');
    setShowGoogleModal(true);
  };

  const handleSelectGoogleUser = (name, email) => {
    setLoadingAccountName(name);
    setLoadingAccountEmail(email);
    setGoogleStep('loading');
    
    setTimeout(() => {
      const user = loginUser(email, 'password');
      if (user) {
        window.dispatchEvent(new Event('rk-user-changed'));
        setShowGoogleModal(false);
        navigate('/dashboard');
      }
    }, 1500);
  };

  const handleCustomGoogleSubmit = (e) => {
    e.preventDefault();
    const emailStr = googleCustomEmail.trim();
    const nameStr = googleCustomName.trim();

    if (!nameStr) {
      setGoogleCustomError('Nama lengkap wajib diisi.');
      return;
    }
    if (!emailStr) {
      setGoogleCustomError('Email wajib diisi.');
      return;
    }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailStr)) {
      setGoogleCustomError('Format alamat email Google tidak valid.');
      return;
    }

    setGoogleStep('loading');
    setLoadingAccountName(nameStr);
    setLoadingAccountEmail(emailStr);

    setTimeout(() => {
      const user = loginUser(emailStr, 'password');
      if (user) {
        const users = JSON.parse(localStorage.getItem('rk_users') || '[]');
        const idx = users.findIndex(u => u.email.toLowerCase() === emailStr.toLowerCase());
        if (idx > -1) {
          users[idx].name = nameStr;
          localStorage.setItem('rk_users', JSON.stringify(users));
          localStorage.setItem('rk_current_user', JSON.stringify(users[idx]));
        }
        
        window.dispatchEvent(new Event('rk-user-changed'));
        setShowGoogleModal(false);
        navigate('/dashboard');
      }
    }, 1800);
  };

  const registeredUsers = getUsers();

  return (
    <div className="min-h-[80vh] flex flex-col justify-center items-center px-4 relative">
      
      {/* Main Login Card */}
      <div className="w-full max-w-md p-8 bg-white dark:bg-[#1A1A1A] rounded-2xl shadow-sm border border-stone-200 dark:border-stone-800 transition-colors duration-300">
        <div className="text-center mb-8">
          <h1 className="text-4xl font-serif text-[#8B5E3C] dark:text-[#C9A27C] mb-2 tracking-tight font-bold">RuangKata</h1>
          <p className="text-stone-500 dark:text-stone-400 font-serif text-lg italic">Rumah Digital untuk Puisi.</p>
        </div>

        {error && (
          <div className="bg-red-50 dark:bg-red-950/20 text-red-600 dark:text-red-400 p-4 rounded-lg mb-6 text-sm text-center border border-red-100 dark:border-red-900/30">
            {error}
          </div>
        )}

        <form onSubmit={handleLogin} className="space-y-4 mb-6">
          <div>
            <label className="block text-xs font-bold uppercase tracking-widest text-stone-500 mb-2">Email</label>
            <input
              type="email"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              placeholder="Masukkan Email Anda"
              className="w-full bg-stone-50 dark:bg-[#151515] border border-stone-200 dark:border-stone-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#8B5E3C] dark:focus:border-[#C9A27C] text-[#1A1A1A] dark:text-[#EAEAEA]"
              required
            />
          </div>
          <div>
            <label className="block text-xs font-bold uppercase tracking-widest text-stone-500 mb-2">Password</label>
            <input
              type="password"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              placeholder="••••••••"
              className="w-full bg-stone-50 dark:bg-[#151515] border border-stone-200 dark:border-stone-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#8B5E3C] dark:focus:border-[#C9A27C] text-[#1A1A1A] dark:text-[#EAEAEA]"
            />
          </div>
          <button
            type="submit"
            className="w-full py-3 bg-[#8B5E3C] dark:bg-[#C9A27C] text-white dark:text-[#1A1A1A] rounded-xl font-bold text-sm hover:opacity-90 transition-opacity uppercase tracking-widest cursor-pointer animate-none"
          >
            Masuk / Daftar
          </button>
        </form>

        <div className="relative flex py-4 items-center">
          <div className="flex-grow border-t border-stone-200 dark:border-stone-800"></div>
          <span className="flex-shrink mx-4 text-stone-400 text-xs font-bold uppercase tracking-widest">atau</span>
          <div className="flex-grow border-t border-stone-200 dark:border-stone-800"></div>
        </div>

        {/* 🌟 NATIVE GOOGLE OAUTH VS DEMO DECORATION */}
        {isGoogleConfigured ? (
          <div className="w-full flex flex-col items-center gap-2">
            <div className="w-full py-1 text-center text-[10px] text-emerald-600 dark:text-emerald-400 font-bold uppercase tracking-widest flex items-center justify-center gap-1">
              <span className="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
              Real Google Sign-In Aktif
            </div>
            {/* Element where official Google Sign-In button is rendered */}
            <div id="googleBtnParent" className="w-full min-h-[46px]"></div>
          </div>
        ) : (
          <div className="w-full flex flex-col gap-3">
            {/* Warning that Google Client ID is not configured yet */}
            <div className="bg-amber-50/50 dark:bg-amber-950/10 border border-amber-200/60 dark:border-amber-900/30 rounded-xl p-3.5 flex items-start gap-3">
              <AlertCircle className="w-5 h-5 text-amber-600 dark:text-amber-500 shrink-0 mt-0.5" />
              <div className="text-[11px] text-amber-800 dark:text-amber-300 leading-relaxed">
                <span className="font-bold">Real Google OAuth Aktif</span>. Masukkan Client ID Anda di file <code className="bg-amber-100 dark:bg-amber-900/40 px-1 py-0.5 rounded font-mono text-[10px]">.env</code> sebagai <code className="bg-amber-100 dark:bg-amber-900/40 px-1 py-0.5 rounded font-mono text-[10px]">VITE_GOOGLE_CLIENT_ID</code> untuk mengaktifkan pop-up asli Google secara otomatis.
              </div>
            </div>

            {/* Interactive Mock Button as dynamic placeholder */}
            <button
              onClick={handleGoogleLoginClick}
              className="w-full flex items-center justify-center gap-3 bg-white dark:bg-transparent border border-stone-300 dark:border-stone-800 rounded-xl px-6 py-3 text-stone-700 dark:text-stone-300 font-medium hover:bg-stone-50 dark:hover:bg-[#151515] transition-colors focus:ring-2 focus:ring-[#8B5E3C] focus:outline-none cursor-pointer"
            >
              <svg className="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
              </svg>
              Masuk dengan Google (Demo Mode)
            </button>
          </div>
        )}

        <div className="mt-8 text-center text-xs text-stone-400">
          Dengan melanjutkan, Anda menyetujui <a href="#" className="underline hover:text-stone-600">Ketentuan Layanan</a> dan <a href="#" className="underline hover:text-stone-600">Kebijakan Privasi</a> RuangKata.
        </div>
      </div>

      <div className="mt-8">
        <Link to="/" className="text-stone-400 hover:text-[#8B5E3C] flex items-center gap-2 group transition-colors">
          <CornerUpLeft className="w-4 h-4 group-hover:-translate-x-1 transition-transform" />
          Kembali ke Beranda
        </Link>
      </div>

      {/* Premium Google Account Chooser Modal (Interactive Mock OAuth) */}
      {showGoogleModal && (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 dark:bg-black/80 backdrop-blur-sm animate-fade-in">
          
          <div className="relative w-full max-w-[420px] bg-white dark:bg-[#121212] rounded-2xl shadow-2xl border border-stone-200 dark:border-stone-800 overflow-hidden flex flex-col animate-scale-up">
            
            {/* Top Close Button */}
            {googleStep !== 'loading' && (
              <button 
                onClick={() => setShowGoogleModal(false)}
                className="absolute top-4 right-4 text-stone-400 hover:text-stone-600 dark:hover:text-stone-200 transition-colors text-lg focus:outline-none cursor-pointer"
              >
                ✕
              </button>
            )}

            {/* Google Brand Header */}
            <div className="p-8 pb-4 text-center">
              <div className="flex justify-center mb-4">
                <svg className="w-8 h-8" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                  <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                  <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                  <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
              </div>

              {googleStep === 'chooser' && (
                <>
                  <h3 className="text-xl font-medium text-stone-800 dark:text-stone-100">Pilih akun</h3>
                  <p className="text-xs text-stone-500 dark:text-stone-400 mt-1">untuk melanjutkan ke <span className="font-semibold text-[#8B5E3C] dark:text-[#C9A27C]">RuangKata</span></p>
                </>
              )}

              {googleStep === 'custom' && (
                <>
                  <h3 className="text-xl font-medium text-stone-800 dark:text-stone-100">Hubungkan Akun Google Baru</h3>
                  <p className="text-xs text-stone-500 dark:text-stone-400 mt-1 font-serif italic">Gunakan email Google pilihanmu untuk login</p>
                </>
              )}

              {googleStep === 'loading' && (
                <>
                  <h3 className="text-lg font-medium text-stone-800 dark:text-stone-100">Memverifikasi dengan Google...</h3>
                  <p className="text-xs text-stone-500 dark:text-stone-400 mt-1">Menghubungkan sesi aman...</p>
                </>
              )}
            </div>

            {/* Step 1: Account Chooser List */}
            {googleStep === 'chooser' && (
              <div className="flex-grow flex flex-col">
                <div className="max-h-[260px] overflow-y-auto px-6 py-2 border-t border-b border-stone-100 dark:border-stone-800/80">
                  {registeredUsers.length > 0 ? (
                    registeredUsers.map((usr, i) => {
                      const colorPalette = [
                        'bg-amber-100 dark:bg-amber-950/40 text-amber-700 dark:text-amber-300',
                        'bg-rose-100 dark:bg-rose-950/40 text-rose-700 dark:text-rose-300',
                        'bg-emerald-100 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300',
                        'bg-blue-100 dark:bg-blue-950/40 text-blue-700 dark:text-blue-300',
                      ];
                      const styleClass = colorPalette[usr.id % colorPalette.length];
                      
                      return (
                        <button
                          key={usr.email}
                          onClick={() => handleSelectGoogleUser(usr.name, usr.email)}
                          className="w-full flex items-center gap-4 py-3.5 px-3 rounded-xl hover:bg-stone-50 dark:hover:bg-stone-800/40 transition-colors text-left cursor-pointer group"
                        >
                          <div className={`w-10 h-10 rounded-full flex items-center justify-center font-bold text-base shadow-inner border border-stone-200/50 dark:border-stone-700/30 ${styleClass}`}>
                            {usr.name.charAt(0).toUpperCase()}
                          </div>
                          <div className="flex-grow min-w-0">
                            <p className="font-semibold text-sm text-stone-700 dark:text-stone-200 group-hover:text-stone-900 dark:group-hover:text-white truncate">
                              {usr.name}
                            </p>
                            <p className="text-xs text-stone-400 dark:text-stone-500 truncate">
                              {usr.email}
                            </p>
                          </div>
                          <ArrowRight className="w-4 h-4 text-stone-300 group-hover:text-stone-500 group-hover:translate-x-0.5 transition-all" />
                        </button>
                      );
                    })
                  ) : (
                    <div className="py-6 text-center text-stone-400 text-sm">Tidak ada akun terdaftar</div>
                  )}
                </div>

                {/* Gunakan Akun Lain Button */}
                <div className="p-4 px-6">
                  <button
                    onClick={() => {
                      setGoogleCustomName('');
                      setGoogleCustomEmail('');
                      setGoogleCustomError('');
                      setGoogleStep('custom');
                    }}
                    className="w-full flex items-center justify-center gap-2 py-3 border border-dashed border-stone-300 dark:border-stone-800 rounded-xl text-stone-600 dark:text-stone-300 text-xs font-semibold uppercase tracking-wider hover:bg-stone-50 dark:hover:bg-stone-800/20 transition-all cursor-pointer"
                  >
                    <UserPlus className="w-4 h-4" />
                    Gunakan Akun Lain
                  </button>
                </div>
              </div>
            )}

            {/* Step 2: Custom Google Account Entry Form */}
            {googleStep === 'custom' && (
              <form onSubmit={handleCustomGoogleSubmit} className="p-6 px-8 flex-grow flex flex-col gap-4 border-t border-stone-100 dark:border-stone-800/80">
                {googleCustomError && (
                  <div className="bg-red-50 dark:bg-red-950/20 border border-red-100 dark:border-red-900/30 text-red-600 dark:text-red-400 px-4 py-2.5 rounded-xl text-xs text-center font-medium">
                    {googleCustomError}
                  </div>
                )}

                <div className="space-y-4">
                  <div>
                    <label className="block text-[10px] font-bold uppercase tracking-widest text-stone-400 mb-1.5">Nama Lengkap</label>
                    <input
                      type="text"
                      value={googleCustomName}
                      onChange={(e) => setGoogleCustomName(e.target.value)}
                      placeholder="e.g. Fauzan Raka"
                      className="w-full bg-stone-50 dark:bg-[#161616] border border-stone-200 dark:border-stone-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#4285F4] text-stone-800 dark:text-stone-100 transition-colors"
                      required
                    />
                  </div>
                  
                  <div>
                    <label className="block text-[10px] font-bold uppercase tracking-widest text-stone-400 mb-1.5">Alamat Email Google (Gmail)</label>
                    <input
                      type="email"
                      value={googleCustomEmail}
                      onChange={(e) => setGoogleCustomEmail(e.target.value)}
                      placeholder="username@gmail.com"
                      className="w-full bg-stone-50 dark:bg-[#161616] border border-stone-200 dark:border-stone-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#4285F4] text-stone-800 dark:text-stone-100 transition-colors"
                      required
                    />
                  </div>
                </div>

                <div className="flex gap-3 mt-4">
                  <button
                    type="button"
                    onClick={() => {
                      setGoogleStep('chooser');
                      setGoogleCustomError('');
                    }}
                    className="flex-1 py-3 bg-stone-100 dark:bg-stone-800 hover:bg-stone-200 dark:hover:bg-stone-700 text-stone-700 dark:text-stone-200 rounded-xl font-bold text-xs uppercase tracking-wider transition-colors cursor-pointer"
                  >
                    Batal
                  </button>
                  <button
                    type="submit"
                    className="flex-grow-[1.5] py-3 bg-[#4285F4] hover:bg-[#357AE8] text-white rounded-xl font-bold text-xs uppercase tracking-wider transition-colors flex items-center justify-center gap-2 cursor-pointer shadow-md shadow-[#4285F4]/10"
                  >
                    Lanjutkan
                    <ArrowRight className="w-4 h-4" />
                  </button>
                </div>
              </form>
            )}

            {/* Step 3: Circular Multi-color Google Loader */}
            {googleStep === 'loading' && (
              <div className="flex-grow flex flex-col items-center justify-center p-12 gap-6 border-t border-stone-100 dark:border-stone-800/80">
                <div className="relative w-16 h-16 flex items-center justify-center">
                  <div className="w-12 h-12 rounded-full border-4 border-[#4285F4]/30 border-t-[#4285F4] border-r-[#EA4335] border-b-[#FBBC05] border-l-[#34A853] animate-spin"></div>
                </div>

                <div className="text-center">
                  <p className="font-semibold text-stone-800 dark:text-stone-100 text-sm">{loadingAccountName}</p>
                  <p className="text-xs text-stone-400 dark:text-stone-500 mt-0.5">{loadingAccountEmail}</p>
                </div>

                <p className="text-[10px] text-stone-400 dark:text-stone-500 font-medium uppercase tracking-widest text-center">
                  Harap tunggu, Google sedang memproses masuk...
                </p>
              </div>
            )}

            {/* Dialog Footer */}
            <div className="bg-stone-50 dark:bg-[#151515] p-4 px-8 border-t border-stone-100 dark:border-stone-800/40 flex items-center justify-between text-[10px] text-stone-400 dark:text-stone-500 font-medium">
              <span>Bahasa Indonesia</span>
              <div className="flex gap-4">
                <a href="#" className="hover:text-stone-600 dark:hover:text-stone-300">Bantuan</a>
                <a href="#" className="hover:text-stone-600 dark:hover:text-stone-300">Privasi</a>
                <a href="#" className="hover:text-stone-600 dark:hover:text-stone-300">Ketentuan</a>
              </div>
            </div>

          </div>

        </div>
      )}

    </div>
  );
}
