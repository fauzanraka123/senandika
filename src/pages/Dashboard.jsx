import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { getMyPoems, deletePoem, getCurrentUser } from '../mockDb';
import { Edit2, Trash2, Plus, FileText, CheckCircle, Clock } from 'lucide-react';

export default function Dashboard() {
  const [myPoems, setMyPoems] = useState([]);
  const [currentUser, setCurrentUser] = useState(getCurrentUser());

  useEffect(() => {
    setMyPoems(getMyPoems());
  }, []);

  const handleDelete = (id) => {
    if (window.confirm('Apakah Anda yakin ingin menghapus puisi ini?')) {
      deletePoem(id);
      setMyPoems(prev => prev.filter(p => p.id !== id));
    }
  };

  const publishedPoems = myPoems.filter(p => p.status === 'published');
  const draftPoems = myPoems.filter(p => p.status === 'draft');

  return (
    <div className="min-h-screen bg-stone-50 dark:bg-[#0A0A0A] py-12 transition-colors duration-300">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {/* Header */}
        <div className="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-12">
          <div>
            <h1 className="text-3xl font-serif font-bold text-stone-900 dark:text-stone-100 mb-2">
              Beranda Penyair
            </h1>
            <p className="text-stone-500 dark:text-stone-400 text-sm">
              Selamat datang kembali, <span className="font-bold text-[#8B5E3C] dark:text-[#C9A27C]">{currentUser?.name}</span>. Kelola bait-bait inspirasimu di sini.
            </p>
          </div>
          
          <Link
            to="/dashboard/poems/create"
            className="inline-flex items-center gap-2 bg-[#8B5E3C] hover:bg-[#704B30] dark:bg-[#C9A27C] dark:hover:bg-[#DEB887] text-white dark:text-[#1A1A1A] px-6 py-3 rounded-full font-bold text-xs uppercase tracking-widest transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5"
          >
            <Plus className="h-4 w-4" />
            Tulis Puisi Baru
          </Link>
        </div>

        {/* Stats Blocks */}
        <div className="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-12">
          <div className="bg-white dark:bg-[#1A1A1A] border border-stone-100 dark:border-stone-800 p-6 rounded-2xl shadow-sm flex items-center gap-4">
            <div className="p-3 bg-stone-50 dark:bg-[#151515] rounded-xl text-stone-600 dark:text-stone-400">
              <FileText className="h-6 w-6" />
            </div>
            <div>
              <span className="block text-2xl font-bold font-sans text-stone-900 dark:text-stone-100">{myPoems.length}</span>
              <span className="text-xs text-stone-500 uppercase tracking-widest font-bold">Total Puisi</span>
            </div>
          </div>
          
          <div className="bg-white dark:bg-[#1A1A1A] border border-stone-100 dark:border-stone-800 p-6 rounded-2xl shadow-sm flex items-center gap-4">
            <div className="p-3 bg-stone-50 dark:bg-[#151515] rounded-xl text-[#8B5E3C] dark:text-[#C9A27C]">
              <CheckCircle className="h-6 w-6" />
            </div>
            <div>
              <span className="block text-2xl font-bold font-sans text-stone-900 dark:text-stone-100">{publishedPoems.length}</span>
              <span className="text-xs text-stone-500 uppercase tracking-widest font-bold">Dipublikasikan</span>
            </div>
          </div>

          <div className="bg-white dark:bg-[#1A1A1A] border border-stone-100 dark:border-stone-800 p-6 rounded-2xl shadow-sm flex items-center gap-4">
            <div className="p-3 bg-stone-50 dark:bg-[#151515] rounded-xl text-stone-400">
              <Clock className="h-6 w-6" />
            </div>
            <div>
              <span className="block text-2xl font-bold font-sans text-stone-900 dark:text-stone-100">{draftPoems.length}</span>
              <span className="text-xs text-stone-500 uppercase tracking-widest font-bold">Draf</span>
            </div>
          </div>
        </div>

        {/* Poems Management List */}
        <div className="bg-white dark:bg-[#1A1A1A] rounded-[2rem] border border-stone-100 dark:border-stone-800 shadow-sm overflow-hidden">
          <div className="px-8 py-6 border-b border-stone-100 dark:border-stone-800 bg-stone-50 dark:bg-[#151515] flex justify-between items-center">
            <h2 className="font-serif font-bold text-stone-900 dark:text-stone-100 text-lg">Daftar Puisi Anda</h2>
          </div>
          
          {myPoems.length > 0 ? (
            <div className="divide-y divide-stone-100 dark:divide-stone-800">
              {myPoems.map((poem) => (
                <div key={poem.id} className="p-8 flex flex-col md:flex-row md:items-center md:justify-between gap-6 hover:bg-stone-50/50 dark:hover:bg-[#151515]/30 transition-colors">
                  <div className="flex-grow max-w-3xl">
                    <div className="flex items-center gap-3 mb-2">
                      <span className={`text-[10px] font-bold uppercase tracking-widest px-2.5 py-1 rounded-full ${
                        poem.status === 'published'
                          ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-950/20 dark:text-emerald-400'
                          : 'bg-stone-100 text-stone-500 dark:bg-[#151515] dark:text-stone-400'
                      }`}>
                        {poem.status === 'published' ? 'Terbit' : 'Draf'}
                      </span>
                      <span className="text-xs text-stone-400">
                        {new Date(poem.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })}
                      </span>
                    </div>
                    
                    <h3 className="text-xl font-serif font-bold text-stone-900 dark:text-stone-100 hover:text-[#8B5E3C] dark:hover:text-[#C9A27C] transition-colors mb-2">
                      <Link to={`/poems/${poem.slug}`}>{poem.title}</Link>
                    </h3>
                    
                    <p className="text-stone-500 dark:text-stone-400 text-sm italic font-serif line-clamp-1">
                      "{poem.excerpt || 'Tidak ada kutipan...'}"
                    </p>
                  </div>

                  <div className="flex items-center gap-3 flex-shrink-0">
                    <Link
                      to={`/dashboard/poems/edit/${poem.slug}`}
                      className="p-3 bg-stone-50 dark:bg-[#151515] text-stone-600 dark:text-stone-400 hover:bg-[#8B5E3C] hover:text-white dark:hover:bg-[#C9A27C] dark:hover:text-[#1A1A1A] rounded-full transition-all border border-stone-200 dark:border-stone-800 shadow-sm"
                      title="Edit Puisi"
                    >
                      <Edit2 className="h-4 w-4" />
                    </Link>
                    
                    <button
                      onClick={() => handleDelete(poem.id)}
                      className="p-3 bg-stone-50 dark:bg-[#151515] text-stone-400 hover:bg-red-500 hover:text-white rounded-full transition-all border border-stone-200 dark:border-stone-800 shadow-sm cursor-pointer"
                      title="Hapus"
                    >
                      <Trash2 className="h-4 w-4" />
                    </button>
                  </div>
                </div>
              ))}
            </div>
          ) : (
            <div className="p-16 text-center">
              <p className="text-stone-500 dark:text-stone-400 font-serif italic mb-6">
                Anda belum menulis puisi apapun. Mulailah merangkai karya pertamamu!
              </p>
              <Link
                to="/dashboard/poems/create"
                className="inline-flex items-center gap-2 bg-[#8B5E3C] dark:bg-[#C9A27C] text-white dark:text-[#1A1A1A] px-6 py-3 rounded-full font-bold text-xs uppercase tracking-widest shadow-md hover:shadow-lg transition-all"
              >
                Tulis Sekarang
              </Link>
            </div>
          )}
        </div>

      </div>
    </div>
  );
}
