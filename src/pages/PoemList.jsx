import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { getPoems, getCategories } from '../mockDb';
import { Heart, Eye, Search } from 'lucide-react';

export default function PoemList() {
  const [poems, setPoems] = useState([]);
  const [categories, setCategories] = useState([]);
  const [selectedCategory, setSelectedCategory] = useState(null);
  const [searchQuery, setSearchQuery] = useState('');

  useEffect(() => {
    setPoems(getPoems());
    setCategories(getCategories());
  }, []);

  const filteredPoems = poems.filter(poem => {
    const matchesCategory = !selectedCategory || poem.category_id === selectedCategory;
    const matchesSearch = poem.title.toLowerCase().includes(searchQuery.toLowerCase()) || 
                          poem.writer.name.toLowerCase().includes(searchQuery.toLowerCase()) || 
                          poem.excerpt?.toLowerCase().includes(searchQuery.toLowerCase());
    return matchesCategory && matchesSearch;
  });

  return (
    <div className="min-h-screen bg-[#F8F6F2] dark:bg-[#0F0F0F] py-16 md:py-24 transition-colors duration-300">
      <div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {/* Header */}
        <div className="text-center mb-16">
          <span className="text-xs font-bold text-[#8B5E3C] dark:text-[#C9A27C] uppercase tracking-[0.3em] mb-4 block bg-[#8B5E3C]/10 dark:bg-[#C9A27C]/10 inline-block px-4 py-1.5 rounded-full">Katalog Karya</span>
          <h1 className="text-4xl md:text-5xl font-serif text-[#1A1A1A] dark:text-[#EAEAEA] tracking-tight mb-6 transition-colors font-bold">RuangKata Semesta</h1>
          <p className="text-stone-500 dark:text-stone-400 max-w-xl mx-auto font-serif italic text-lg leading-relaxed">
            Menelusuri rimba aksara, menemukan kedamaian dalam setiap bait rima.
          </p>
        </div>

        {/* Filters and Search */}
        <div className="bg-white dark:bg-[#1A1A1A] rounded-[2rem] border border-stone-100 dark:border-stone-800 p-6 shadow-sm mb-12 flex flex-col md:flex-row gap-6 justify-between items-center">
          {/* Categories */}
          <div className="flex flex-wrap gap-2 w-full md:w-auto">
            <button
              onClick={() => setSelectedCategory(null)}
              className={`px-4 py-2 rounded-full text-xs font-bold transition-all cursor-pointer ${
                !selectedCategory
                  ? 'bg-[#8B5E3C] text-white dark:bg-[#C9A27C] dark:text-[#1A1A1A]'
                  : 'bg-stone-50 text-stone-600 hover:bg-stone-100 dark:bg-[#151515] dark:text-stone-400 dark:hover:bg-[#202020]'
              }`}
            >
              Semua
            </button>
            {categories.map((cat) => (
              <button
                key={cat.id}
                onClick={() => setSelectedCategory(cat.id)}
                className={`px-4 py-2 rounded-full text-xs font-bold transition-all cursor-pointer ${
                  selectedCategory === cat.id
                    ? 'bg-[#8B5E3C] text-white dark:bg-[#C9A27C] dark:text-[#1A1A1A]'
                    : 'bg-stone-50 text-stone-600 hover:bg-stone-100 dark:bg-[#151515] dark:text-stone-400 dark:hover:bg-[#202020]'
                }`}
              >
                {cat.name}
              </button>
            ))}
          </div>

          {/* Search bar */}
          <div className="relative w-full md:w-80">
            <input
              type="text"
              placeholder="Cari puisi atau penyair..."
              value={searchQuery}
              onChange={(e) => setSearchQuery(e.target.value)}
              className="w-full bg-stone-50 dark:bg-[#151515] text-[#1A1A1A] dark:text-[#EAEAEA] border border-stone-100 dark:border-stone-800 rounded-full py-2.5 pl-10 pr-4 text-sm focus:outline-none focus:border-[#8B5E3C] dark:focus:border-[#C9A27C] transition-all"
            />
            <Search className="absolute left-3.5 top-3.5 w-4 h-4 text-stone-400" />
          </div>
        </div>

        {/* Poem Cards */}
        {filteredPoems.length > 0 ? (
          <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
            {filteredPoems.map((poem) => (
              <article key={poem.id} className="bg-white dark:bg-[#1A1A1A] rounded-[2rem] shadow-sm border border-stone-100 dark:border-stone-800 p-6 hover:shadow-xl transition-all duration-300 relative overflow-hidden group flex flex-col justify-between">
                <div className="absolute inset-0 bg-gradient-to-br from-stone-50 to-transparent dark:from-stone-800/10 dark:to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none z-0"></div>
                <div className="relative z-10">
                  <div className="flex items-center justify-between mb-5">
                    <span className="text-[10px] font-bold uppercase tracking-widest bg-[#8B5E3C]/10 dark:bg-[#C9A27C]/10 text-[#8B5E3C] dark:text-[#C9A27C] px-3 py-1 rounded-full">
                      {poem.category.name}
                    </span>
                    <span className="text-[10px] text-stone-400 font-bold uppercase tracking-widest">
                      {new Date(poem.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short' })}
                    </span>
                  </div>

                  <Link to={`/poems/${poem.slug}`} className="block group/title">
                    <h3 className="text-2xl font-serif font-bold text-[#1A1A1A] dark:text-[#EAEAEA] group-hover/title:text-[#8B5E3C] dark:group-hover/title:text-[#C9A27C] transition-colors mb-3 line-clamp-1">
                      {poem.title}
                    </h3>
                    <p className="font-serif italic text-base leading-relaxed text-stone-600 dark:text-stone-400 mb-6 line-clamp-3">
                      "{poem.excerpt || "Mari dengarkan suara jiwa..."}"
                    </p>
                  </Link>
                </div>

                <div className="relative z-10 flex items-center justify-between pt-5 border-t border-stone-100 dark:border-stone-800/60 mt-auto">
                  <div className="flex items-center gap-2">
                    <div className="w-8 h-8 rounded-full bg-stone-100 dark:bg-[#151515] flex items-center justify-center text-stone-600 dark:text-stone-300 font-serif font-bold text-xs shadow-sm border border-stone-100 dark:border-stone-800">
                      {poem.writer.name.charAt(0)}
                    </div>
                    <div className="flex flex-col">
                      <span className="text-xs font-bold text-[#1A1A1A] dark:text-[#EAEAEA]">{poem.writer.name}</span>
                    </div>
                  </div>
                  <div className="flex items-center gap-3 text-stone-500">
                    <span className="flex items-center gap-1.5 font-medium bg-stone-50 dark:bg-[#151515] px-2 py-1 rounded-full text-[10px]">
                      <Heart className="w-3.5 h-3.5 text-rose-500 fill-rose-500" />
                      {poem.likes_count}
                    </span>
                    <span className="flex items-center gap-1.5 font-medium bg-stone-50 dark:bg-[#151515] px-2 py-1 rounded-full text-[10px]">
                      <Eye className="w-3.5 h-3.5" />
                      {poem.views || 36}
                    </span>
                  </div>
                </div>
              </article>
            ))}
          </div>
        ) : (
          <div className="py-20 text-center bg-white dark:bg-[#1A1A1A] rounded-[3rem] border border-stone-100 dark:border-stone-800 shadow-sm">
            <p className="text-xl font-serif text-stone-500 dark:text-stone-400 italic">Tidak ada puisi yang sesuai dengan pencarian Anda.</p>
          </div>
        )}

      </div>
    </div>
  );
}
