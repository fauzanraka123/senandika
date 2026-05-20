import React, { useState, useEffect } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { getPoems, getUsers, getCurrentUser } from '../mockDb';
import { Heart, Eye, UserPlus } from 'lucide-react';

export default function Welcome() {
  const navigate = useNavigate();
  const [poems, setPoems] = useState([]);
  const [writers, setWriters] = useState([]);
  const [currentUser] = useState(getCurrentUser());
  const [followingList, setFollowingList] = useState(() => {
    return JSON.parse(localStorage.getItem('rk_following') || '[]');
  });

  useEffect(() => {
    setPoems(getPoems());
    const allUsers = getUsers();
    setWriters(allUsers.filter(u => !currentUser || u.id !== currentUser.id));
  }, [currentUser]);

  const handleFollowToggle = (writerId) => {
    if (!currentUser) { navigate('/login'); return; }
    const updated = followingList.includes(writerId)
      ? followingList.filter(id => id !== writerId)
      : [...followingList, writerId];
    setFollowingList(updated);
    localStorage.setItem('rk_following', JSON.stringify(updated));
  };

  const followingPoems = poems.filter(p => followingList.includes(p.user_id));
  const popularPoems = [...poems].sort((a, b) => b.likes_count - a.likes_count).slice(0, 3);
  const latestPoems = [...poems].sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

  return (
    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20">
      <div className="flex flex-col lg:flex-row gap-12 lg:gap-16">
        
        {/* Main Feed (Left Column) */}
        <div className="lg:w-2/3 space-y-16">
          
          {/* Section: Puisi dari Penyair yang Diikuti */}
          {currentUser && (
            <section>
              <div className="flex items-center justify-between mb-8">
                <h2 className="text-2xl md:text-3xl font-serif font-bold text-[#1A1A1A] dark:text-[#EAEAEA]">Dari Penyair yang Kamu Ikuti</h2>
              </div>
              
              {followingPoems.length > 0 ? (
                <div className="grid grid-cols-1 gap-8">
                  {followingPoems.map((poem) => (
                    <div key={poem.id} className="bg-white dark:bg-[#1A1A1A] rounded-[2rem] shadow-sm border border-stone-100 dark:border-stone-800 p-6 md:p-8 hover:shadow-xl transition-all relative overflow-hidden group">
                      <div className="absolute inset-0 bg-gradient-to-br from-stone-50 to-transparent dark:from-stone-800/10 dark:to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none z-0"></div>
                      <div className="relative z-10">
                        <div className="flex items-center gap-3 mb-6">
                          <div className="w-10 h-10 rounded-full bg-stone-100 dark:bg-[#151515] flex items-center justify-center text-stone-600 dark:text-stone-300 font-serif font-bold text-sm shadow-sm border border-stone-100 dark:border-stone-800">
                            {poem.writer.name.charAt(0)}
                          </div>
                          <div className="flex flex-col">
                            <span className="text-sm font-bold text-[#1A1A1A] dark:text-[#EAEAEA]">{poem.writer.name}</span>
                            <span className="text-[10px] text-stone-500 font-bold uppercase tracking-widest">Baru saja</span>
                          </div>
                        </div>
                        <Link to={`/poems/${poem.slug}`} className="block group/title">
                          <h3 className="text-2xl font-serif font-bold text-[#1A1A1A] dark:text-[#EAEAEA] group-hover/title:text-[#8B5E3C] dark:group-hover/title:text-[#C9A27C] transition-colors mb-3">
                            {poem.title}
                          </h3>
                          <p className="font-serif italic text-lg leading-relaxed text-stone-600 dark:text-stone-400 line-clamp-3 mb-6">
                            "{poem.excerpt || "Tinta menanti..."}"
                          </p>
                        </Link>
                        <div className="flex items-center justify-between mt-4 pt-5 border-t border-stone-100 dark:border-stone-800/60">
                          <div className="flex items-center gap-3 text-stone-500">
                            <span className="flex items-center gap-1.5 font-medium bg-stone-50 dark:bg-[#151515] px-2.5 py-1 rounded-full text-xs" title="Suka">
                              <Heart className="w-4 h-4 text-rose-500 fill-rose-500" />
                              {poem.likes_count}
                            </span>
                            <span className="flex items-center gap-1.5 font-medium bg-stone-50 dark:bg-[#151515] px-2.5 py-1 rounded-full text-xs" title="Penayangan">
                              <Eye className="w-4 h-4" />
                              {poem.views || 42}
                            </span>
                          </div>
                          <Link to={`/poems/${poem.slug}`} className="inline-flex items-center gap-1 text-[10px] font-bold text-[#8B5E3C] dark:text-[#C9A27C] hover:text-[#704B30] dark:hover:text-[#DEB887] uppercase tracking-widest bg-[#8B5E3C]/5 dark:bg-[#C9A27C]/5 px-3 py-1.5 rounded-full transition-colors">
                            Selengkapnya
                          </Link>
                        </div>
                      </div>
                    </div>
                  ))}
                </div>
              ) : (
                <div className="bg-white dark:bg-[#1A1A1A] rounded-[3rem] p-10 text-center border border-stone-100 dark:border-stone-800 shadow-sm">
                  <div className="w-16 h-16 bg-stone-50 dark:bg-[#151515] rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner border border-stone-100 dark:border-stone-800">
                    <UserPlus className="w-8 h-8 text-stone-300 dark:text-stone-600" />
                  </div>
                  <p className="text-stone-600 dark:text-stone-400 font-serif italic text-lg mb-6">Ikuti penyair untuk melihat karya mereka secara eksklusif di sini.</p>
                  <Link to="/writers" className="inline-flex items-center gap-2 px-6 py-3 bg-[#8B5E3C] dark:bg-[#C9A27C] text-white dark:text-[#1A1A1A] rounded-full font-bold shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all uppercase tracking-widest text-[10px]">Temukan Penyair</Link>
                </div>
              )}
            </section>
          )}

          {/* Section: Puisi Terbaru */}
          <section>
            <div className="flex items-center justify-between mb-8">
              <h2 className="text-2xl md:text-3xl font-serif font-bold text-[#1A1A1A] dark:text-[#EAEAEA]">Puisi Terbaru</h2>
            </div>

            {latestPoems.length > 0 ? (
              <div className="space-y-8">
                {latestPoems.map((poem) => (
                  <article key={poem.id} className="bg-white dark:bg-[#1A1A1A] rounded-[2rem] shadow-sm border border-stone-100 dark:border-stone-800 p-6 md:p-8 hover:shadow-xl transition-all duration-300 relative overflow-hidden group">
                    <div className="absolute inset-0 bg-gradient-to-br from-stone-50 to-transparent dark:from-stone-800/10 dark:to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none z-0"></div>
                    <div className="relative z-10 flex flex-col md:flex-row gap-6">
                      <div className="flex-1">
                        <div className="flex items-center gap-3 mb-5">
                          <span className="flex items-center gap-2">
                            <div className="w-8 h-8 rounded-full bg-stone-100 dark:bg-[#151515] flex items-center justify-center text-stone-600 dark:text-stone-300 font-serif font-bold text-xs shadow-sm border border-stone-100 dark:border-stone-800">
                              {poem.writer.name.charAt(0)}
                            </div>
                            <span className="text-sm font-bold text-[#1A1A1A] dark:text-[#EAEAEA]">{poem.writer.name}</span>
                          </span>
                          <span className="text-stone-300 dark:text-stone-700 hidden sm:inline">&bull;</span>
                          <span className="text-[10px] text-stone-500 font-bold uppercase tracking-widest">
                            {new Date(poem.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })}
                          </span>
                        </div>

                        <Link to={`/poems/${poem.slug}`} className="block group/title">
                          <h3 className="text-3xl font-serif font-bold text-[#1A1A1A] dark:text-[#EAEAEA] group-hover/title:text-[#8B5E3C] dark:group-hover/title:text-[#C9A27C] transition-colors mb-4">
                            {poem.title}
                          </h3>
                          <p className="font-serif italic text-lg leading-relaxed text-stone-600 dark:text-stone-400 mb-8 line-clamp-3">
                            "{poem.excerpt || "Biarkan kata-kata mengalir..."}"
                          </p>
                        </Link>

                        <div className="flex items-center justify-between pt-5 border-t border-stone-100 dark:border-stone-800/60">
                          <div className="flex items-center gap-3 text-sm text-stone-500">
                            <span className="flex items-center gap-1.5 font-medium bg-stone-50 dark:bg-[#151515] px-2.5 py-1 rounded-full text-xs">
                              <Heart className="w-4 h-4 text-rose-500 fill-rose-500" />
                              {poem.likes_count}
                            </span>
                            <span className="flex items-center gap-1.5 font-medium bg-stone-50 dark:bg-[#151515] px-2.5 py-1 rounded-full text-xs">
                              <Eye className="w-4 h-4" />
                              {poem.views || 36}
                            </span>
                          </div>
                          <Link to={`/poems/${poem.slug}`} className="inline-flex items-center gap-2 px-5 py-2.5 bg-stone-50 dark:bg-[#151515] text-[#1A1A1A] dark:text-[#EAEAEA] rounded-full text-[10px] uppercase tracking-widest font-bold hover:bg-[#8B5E3C] hover:text-white dark:hover:bg-[#C9A27C] dark:hover:text-[#1A1A1A] transition-all shadow-sm">
                            Baca Selengkapnya
                          </Link>
                        </div>
                      </div>
                    </div>
                  </article>
                ))}
              </div>
            ) : (
              <div className="py-20 text-center bg-white dark:bg-[#1A1A1A] rounded-[3rem] border border-stone-100 dark:border-stone-800 shadow-sm">
                <p className="text-xl font-serif text-stone-500 dark:text-stone-400 italic">Belum ada puisi yang dipublikasikan.</p>
              </div>
            )}
          </section>
        </div>

        {/* Sidebar (Right Column) */}
        <aside className="lg:w-1/3 space-y-12">
          
          {/* Section: Puisi Populer */}
          <section>
            <h2 className="text-xl font-serif font-bold text-[#1A1A1A] dark:text-[#EAEAEA] mb-6 flex items-center gap-2">
              <span className="text-[#8B5E3C] dark:text-[#C9A27C] font-serif">&#10022;</span>
              Puisi Populer
            </h2>
            <div className="space-y-4">
              {popularPoems.map((poem) => (
                <Link key={poem.id} to={`/poems/${poem.slug}`} className="block group p-5 bg-white dark:bg-[#1A1A1A] rounded-[1.5rem] border border-stone-100 dark:border-stone-800 hover:border-[#8B5E3C]/30 dark:hover:border-[#C9A27C]/30 transition-all shadow-sm hover:shadow-md relative overflow-hidden">
                  <div className="absolute inset-0 bg-gradient-to-br from-stone-50 to-transparent dark:from-stone-800/10 dark:to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none z-0"></div>
                  <div className="relative z-10">
                    <h3 className="text-base font-bold text-[#1A1A1A] dark:text-[#EAEAEA] group-hover:text-[#8B5E3C] dark:group-hover:text-[#C9A27C] transition-colors mb-2 line-clamp-1">
                      {poem.title}
                    </h3>
                    <p className="text-xs text-stone-500 mb-3 font-serif italic">oleh {poem.writer.name}</p>
                    <div className="flex items-center gap-3 text-[10px] text-stone-400 font-bold">
                      <span className="flex items-center gap-1">
                        <Heart className="w-3.5 h-3.5 text-rose-500 fill-rose-500" />
                        {poem.likes_count}
                      </span>
                      <span className="flex items-center gap-1">
                        <Eye className="w-3.5 h-3.5" />
                        {poem.views || 36}
                      </span>
                    </div>
                  </div>
                </Link>
              ))}
            </div>
          </section>

          {/* Section: Sidebar Penyair */}
          <section>
            <h2 className="text-xl font-serif font-bold text-[#1A1A1A] dark:text-[#EAEAEA] mb-6 flex items-center gap-2">
              <span className="text-[#8B5E3C] dark:text-[#C9A27C] font-serif">&#10038;</span>
              Penyair Terpopuler
            </h2>
            <div className="space-y-4">
              {writers.map((writer) => {
                const isFollowing = followingList.includes(writer.id);
                return (
                  <div key={writer.id} className="flex items-center justify-between group bg-white dark:bg-[#1A1A1A] p-4 rounded-[1.5rem] border border-stone-100 dark:border-stone-800 shadow-sm hover:shadow-md transition-all">
                    <div className="flex items-center gap-3">
                      <div className="w-10 h-10 rounded-full bg-stone-100 dark:bg-[#151515] flex items-center justify-center text-stone-600 dark:text-stone-300 font-serif font-bold shadow-sm border border-stone-100 dark:border-stone-800">
                        {writer.name.charAt(0)}
                      </div>
                      <div>
                        <h4 className="text-sm font-bold text-[#1A1A1A] dark:text-[#EAEAEA] group-hover:text-[#8B5E3C] dark:group-hover:text-[#C9A27C] transition-colors">{writer.name}</h4>
                        <p className="text-[10px] font-bold text-stone-500 uppercase tracking-widest mt-0.5">{isFollowing ? '1' : '0'} Pengikut</p>
                      </div>
                    </div>
                    
                    <button
                      onClick={() => handleFollowToggle(writer.id)}
                      className={`text-[10px] font-bold px-4 py-2 rounded-full transition-all uppercase tracking-widest cursor-pointer ${
                        isFollowing
                          ? 'bg-stone-100 text-stone-600 hover:bg-stone-200 dark:bg-[#151515] dark:text-stone-300 dark:hover:bg-[#202020]'
                          : 'bg-[#8B5E3C] text-white hover:bg-[#704B30] dark:bg-[#C9A27C] dark:text-[#1A1A1A] dark:hover:bg-[#DEB887]'
                      }`}
                    >
                      {isFollowing ? 'Mengikuti' : 'Ikuti'}
                    </button>
                  </div>
                );
              })}
            </div>
            <div className="mt-8 pt-6 border-t border-stone-100 dark:border-stone-800 text-center">
              <Link to="/writers" className="text-[10px] font-bold text-[#8B5E3C] dark:text-[#C9A27C] hover:underline uppercase tracking-widest">Lihat Semua Penyair</Link>
            </div>
          </section>

          {/* Footer Compact */}
          <div className="pt-12 text-center">
            <p className="text-[10px] text-stone-400 font-bold uppercase tracking-widest">&copy; 2026 RuangKata Poetry Platform</p>
          </div>

        </aside>
      </div>
    </div>
  );
}
