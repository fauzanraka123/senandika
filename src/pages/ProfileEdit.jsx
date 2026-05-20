import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { getCurrentUser, setCurrentUser } from '../mockDb';
import { CornerUpLeft } from 'lucide-react';

export default function ProfileEdit() {
  const navigate = useNavigate();
  const [currentUser, setLocalUser] = useState(getCurrentUser());
  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [bio, setBio] = useState('');

  useEffect(() => {
    if (currentUser) {
      setName(currentUser.name);
      setEmail(currentUser.email);
      setBio(currentUser.bio || '');
    }
  }, [currentUser]);

  const handleSubmit = (e) => {
    e.preventDefault();
    if (!name.trim()) return;
    const updated = { ...currentUser, name, email, bio };
    setCurrentUser(updated);
    window.dispatchEvent(new Event('rk-user-changed'));
    alert('Profil berhasil diperbarui!');
    navigate('/dashboard');
  };

  return (
    <div className="min-h-screen bg-[#F8F6F2] dark:bg-[#0A0A0A] py-12 transition-colors duration-300">
      <div className="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div className="mb-8">
          <button
            onClick={() => navigate('/dashboard')}
            className="inline-flex items-center gap-2 text-sm font-bold uppercase tracking-widest text-stone-600 dark:text-stone-300 hover:text-[#8B5E3C] dark:hover:text-[#C9A27C] transition-colors bg-white dark:bg-[#1A1A1A] px-5 py-2.5 rounded-full shadow-sm border border-stone-200 dark:border-stone-800 hover:shadow-md cursor-pointer"
          >
            <CornerUpLeft className="h-4 w-4" />
            Kembali
          </button>
        </div>

        <div className="bg-white dark:bg-[#1A1A1A] rounded-[2rem] p-8 shadow-sm border border-stone-100 dark:border-stone-800">
          <h2 className="text-2xl font-serif font-bold text-stone-900 dark:text-stone-100 mb-6">Edit Profil</h2>
          
          <form onSubmit={handleSubmit} className="space-y-6">
            <div className="flex flex-col items-center mb-8">
              <div className="w-24 h-24 rounded-full bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center text-[#8B5E3C] dark:text-[#C9A27C] font-serif text-3xl font-bold border border-stone-200 dark:border-stone-700 mb-4 shadow-inner">
                {name.charAt(0)}
              </div>
              <span className="text-xs text-stone-500 uppercase tracking-widest font-bold">Avatar Default</span>
            </div>

            <div>
              <label className="block text-xs font-bold uppercase tracking-widest text-stone-500 mb-2">Nama Lengkap</label>
              <input
                type="text"
                value={name}
                onChange={(e) => setName(e.target.value)}
                placeholder="Fauzan Raka..."
                className="w-full bg-stone-50 dark:bg-[#151515] border border-stone-200 dark:border-stone-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#8B5E3C] dark:focus:border-[#C9A27C] text-[#1A1A1A] dark:text-[#EAEAEA]"
                required
              />
            </div>

            <div>
              <label className="block text-xs font-bold uppercase tracking-widest text-stone-500 mb-2">Alamat Email</label>
              <input
                type="email"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                placeholder="fauzan@ruangkata.com"
                className="w-full bg-stone-50 dark:bg-[#151515] border border-stone-200 dark:border-stone-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#8B5E3C] dark:focus:border-[#C9A27C] text-[#1A1A1A] dark:text-[#EAEAEA]"
                disabled
              />
              <p className="text-[10px] text-stone-400 mt-1">Email akun terhubung tidak dapat diubah.</p>
            </div>

            <div>
              <label className="block text-xs font-bold uppercase tracking-widest text-stone-500 mb-2">Biografi singkat</label>
              <textarea
                value={bio}
                onChange={(e) => setBio(e.target.value)}
                placeholder="Ceritakan sedikit tentang dirimu atau pandangan puitismu..."
                rows={4}
                className="w-full bg-stone-50 dark:bg-[#151515] border border-stone-200 dark:border-stone-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#8B5E3C] dark:focus:border-[#C9A27C] text-[#1A1A1A] dark:text-[#EAEAEA] resize-none"
              />
            </div>

            <button
              type="submit"
              className="w-full py-4 bg-[#8B5E3C] hover:bg-[#704B30] dark:bg-[#C9A27C] dark:hover:bg-[#DEB887] text-white dark:text-[#1A1A1A] rounded-xl font-bold text-xs uppercase tracking-widest shadow-md hover:shadow-lg transition-all cursor-pointer"
            >
              Perbarui Profil
            </button>
          </form>
        </div>

      </div>
    </div>
  );
}
