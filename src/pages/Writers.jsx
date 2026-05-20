import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { getUsers, getPoems, getCurrentUser } from '../mockDb';
import { Star } from 'lucide-react';

export default function Writers() {
  const navigate = useNavigate();
  const [writers, setWriters] = useState([]);
  const [currentUser] = useState(getCurrentUser());
  const [followingList, setFollowingList] = useState(() => {
    return JSON.parse(localStorage.getItem('rk_following') || '[]');
  });

  useEffect(() => {
    const allUsers = getUsers();
    const allPoems = getPoems();
    const mapped = allUsers.map(writer => {
      const writerPoems = allPoems.filter(p => p.user_id === writer.id);
      return {
        ...writer,
        poems_count: writerPoems.length,
        followers_count: followingList.includes(writer.id) ? 1 : 0
      };
    });
    setWriters(mapped);
  }, [followingList]);

  const handleFollowToggle = (writerId) => {
    if (!currentUser) { navigate('/login'); return; }
    const updated = followingList.includes(writerId)
      ? followingList.filter(id => id !== writerId)
      : [...followingList, writerId];
    setFollowingList(updated);
    localStorage.setItem('rk_following', JSON.stringify(updated));
  };

  return (
    <div className="min-h-screen bg-[#F8F6F2] dark:bg-[#0F0F0F] transition-colors duration-300">
      <div className="bg-[#FDFCFB] dark:bg-gray-950 border-b border-gray-100 dark:border-gray-900 py-16 transition-colors duration-300">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h1 className="text-4xl md:text-5xl font-serif text-gray-900 dark:text-gray-100 tracking-tight mb-4 font-bold">Ruang Para Penyair</h1>
          <p className="text-gray-500 dark:text-gray-400 max-w-2xl mx-auto font-serif italic text-lg leading-relaxed">
            Menemukan jiwa-jiwa yang merangkai kata menjadi bait doa dan senandika.
          </p>
        </div>
      </div>

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        {writers.length > 0 ? (
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            {writers.map((writer) => {
              const isFollowing = followingList.includes(writer.id);
              const isMe = currentUser && currentUser.id === writer.id;
              return (
                <div key={writer.id} className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-8 hover:shadow-md transition-all group flex flex-col items-center text-center">
                  <div className="mb-6 relative">
                    <div className="w-24 h-24 rounded-full bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center text-[#8B5E3C] dark:text-[#C9A27C] font-serif text-3xl font-bold border border-stone-200 dark:border-stone-700">
                      {writer.name.charAt(0)}
                    </div>
                    <div className="absolute -bottom-1 -right-1 bg-white dark:bg-gray-800 rounded-full p-1.5 shadow-sm border border-gray-100 dark:border-gray-700">
                      <Star className="w-4 h-4 text-amber-500 fill-current" />
                    </div>
                  </div>
                  <h2 className="text-2xl font-serif font-bold text-gray-900 dark:text-gray-100 mb-2 group-hover:text-[#8B5E3C] dark:group-hover:text-[#C9A27C] transition-colors">{writer.name}</h2>
                  <div className="flex items-center gap-4 text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">
                    <span>{writer.poems_count} Puisi</span>
                    <span className="w-1 h-1 rounded-full bg-gray-300 dark:bg-gray-600"></span>
                    <span>{writer.followers_count} Pengikut</span>
                  </div>
                  <p className="text-gray-600 dark:text-gray-400 font-serif italic mb-8 line-clamp-2 h-12 leading-relaxed">
                    {writer.bio || 'Merasakan dunia melalui setiap bait yang tertulis.'}
                  </p>
                  <div className="w-full pt-6 border-t border-gray-50 dark:border-gray-700 flex flex-col gap-3">
                    {!isMe && (
                      <button
                        onClick={() => handleFollowToggle(writer.id)}
                        className={`w-full py-2.5 text-xs font-bold uppercase tracking-widest transition-colors cursor-pointer ${isFollowing ? 'text-red-500 hover:text-red-600' : 'text-[#8B5E3C] dark:text-[#C9A27C] hover:text-[#704B30]'}`}
                      >
                        {isFollowing ? 'Berhenti Mengikuti' : 'Ikuti Penyair'}
                      </button>
                    )}
                    {isMe && (
                      <span className="w-full py-2.5 text-xs font-bold uppercase tracking-widest text-stone-400">Ini adalah Anda</span>
                    )}
                  </div>
                </div>
              );
            })}
          </div>
        ) : (
          <div className="py-24 text-center bg-white dark:bg-gray-800 rounded-2xl border-2 border-dashed border-gray-100 dark:border-gray-700">
            <p className="text-xl font-serif text-gray-500 italic">Belum ada penyair yang mempublikasikan puisi.</p>
          </div>
        )}
      </div>
    </div>
  );
}
