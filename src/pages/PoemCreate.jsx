import React, { useState, useEffect, useRef } from 'react';
import { useNavigate } from 'react-router-dom';
import { getCategories, savePoem } from '../mockDb';
import { CornerUpLeft } from 'lucide-react';

export default function PoemCreate() {
  const navigate = useNavigate();
  const editorRef = useRef(null);
  const quillInstance = useRef(null);

  const [title, setTitle] = useState('');
  const [categoryId, setCategoryId] = useState('');
  const [excerpt, setExcerpt] = useState('');
  const [content, setContent] = useState('');
  const [categories, setCategories] = useState([]);
  const [status, setStatus] = useState('published');

  useEffect(() => {
    const cats = getCategories();
    setCategories(cats);
    if (cats.length > 0) setCategoryId(cats[0].id.toString());

    if (editorRef.current && !quillInstance.current) {
      quillInstance.current = new window.Quill(editorRef.current, {
        theme: 'snow',
        placeholder: 'Tuliskan bait-bait puisimu di sini...',
        modules: {
          toolbar: [
            ['bold', 'italic', 'underline', 'strike'],
            ['blockquote', 'code-block'],
            [{ 'header': 1 }, { 'header': 2 }],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['clean']
          ]
        }
      });
      quillInstance.current.on('text-change', () => {
        setContent(quillInstance.current.root.innerHTML);
      });
    }
  }, []);

  const handleSave = (e) => {
    e.preventDefault();
    if (!title.trim() || !content.trim()) {
      alert('Judul dan konten puisi wajib diisi!');
      return;
    }
    const saved = savePoem({ title, category_id: categoryId, excerpt, content, status });
    if (saved) navigate('/dashboard');
  };

  const currentCategoryName = categories.find(c => c.id.toString() === categoryId)?.name || 'Kategori';

  return (
    <div className="min-h-screen bg-[#F8F6F2] dark:bg-[#0A0A0A] py-12 transition-colors duration-300">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div className="mb-8">
          <button
            onClick={() => navigate('/dashboard')}
            className="inline-flex items-center gap-2 text-sm font-bold uppercase tracking-widest text-stone-600 dark:text-stone-300 hover:text-[#8B5E3C] dark:hover:text-[#C9A27C] transition-colors bg-white dark:bg-[#1A1A1A] px-5 py-2.5 rounded-full shadow-sm border border-stone-200 dark:border-stone-800 hover:shadow-md cursor-pointer"
          >
            <CornerUpLeft className="h-4 w-4" />
            Kembali
          </button>
        </div>

        <div className="flex flex-col lg:flex-row gap-12">
          
          {/* Form Editor */}
          <div className="lg:w-1/2 space-y-8">
            <div className="bg-white dark:bg-[#1A1A1A] rounded-[2rem] p-8 shadow-sm border border-stone-100 dark:border-stone-800">
              <h2 className="text-2xl font-serif font-bold text-stone-900 dark:text-stone-100 mb-6">Tulis Puisi</h2>
              
              <form onSubmit={handleSave} className="space-y-6">
                <div>
                  <label className="block text-xs font-bold uppercase tracking-widest text-stone-500 mb-2">Judul Puisi</label>
                  <input
                    type="text"
                    value={title}
                    onChange={(e) => setTitle(e.target.value)}
                    placeholder="Masukkan judul puisi indahmu..."
                    className="w-full bg-stone-50 dark:bg-[#151515] border border-stone-200 dark:border-stone-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#8B5E3C] dark:focus:border-[#C9A27C] text-[#1A1A1A] dark:text-[#EAEAEA]"
                    required
                  />
                </div>

                <div>
                  <label className="block text-xs font-bold uppercase tracking-widest text-stone-500 mb-2">Tema/Kategori</label>
                  <select
                    value={categoryId}
                    onChange={(e) => setCategoryId(e.target.value)}
                    className="w-full bg-stone-50 dark:bg-[#151515] border border-stone-200 dark:border-stone-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#8B5E3C] dark:focus:border-[#C9A27C] text-[#1A1A1A] dark:text-[#EAEAEA]"
                  >
                    {categories.map((cat) => (
                      <option key={cat.id} value={cat.id}>{cat.name}</option>
                    ))}
                  </select>
                </div>

                <div>
                  <label className="block text-xs font-bold uppercase tracking-widest text-stone-500 mb-2">Kutipan / Excerpt (Opsional)</label>
                  <textarea
                    value={excerpt}
                    onChange={(e) => setExcerpt(e.target.value)}
                    placeholder="Bait pembuka atau gambaran singkat puisi..."
                    rows={2}
                    className="w-full bg-stone-50 dark:bg-[#151515] border border-stone-200 dark:border-stone-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#8B5E3C] dark:focus:border-[#C9A27C] text-[#1A1A1A] dark:text-[#EAEAEA] resize-none"
                  />
                </div>

                <div>
                  <label className="block text-xs font-bold uppercase tracking-widest text-stone-500 mb-2">Isi Puisi</label>
                  <div className="bg-stone-50 dark:bg-[#151515] border border-stone-200 dark:border-stone-800 rounded-xl overflow-hidden">
                    <div ref={editorRef} className="text-[#1A1A1A] dark:text-[#EAEAEA]" />
                  </div>
                </div>

                <div>
                  <label className="block text-xs font-bold uppercase tracking-widest text-stone-500 mb-2">Status Publikasi</label>
                  <div className="grid grid-cols-2 gap-4">
                    <button
                      type="button"
                      onClick={() => setStatus('published')}
                      className={`py-3 rounded-xl text-xs font-bold uppercase tracking-widest transition-all cursor-pointer ${
                        status === 'published'
                          ? 'bg-[#8B5E3C] text-white dark:bg-[#C9A27C] dark:text-[#1A1A1A]'
                          : 'bg-stone-50 text-stone-600 dark:bg-[#151515] dark:text-stone-400'
                      }`}
                    >
                      Terbitkan
                    </button>
                    <button
                      type="button"
                      onClick={() => setStatus('draft')}
                      className={`py-3 rounded-xl text-xs font-bold uppercase tracking-widest transition-all cursor-pointer ${
                        status === 'draft'
                          ? 'bg-[#8B5E3C] text-white dark:bg-[#C9A27C] dark:text-[#1A1A1A]'
                          : 'bg-stone-50 text-stone-600 dark:bg-[#151515] dark:text-stone-400'
                      }`}
                    >
                      Simpan Draf
                    </button>
                  </div>
                </div>

                <button
                  type="submit"
                  className="w-full py-4 bg-[#8B5E3C] hover:bg-[#704B30] dark:bg-[#C9A27C] dark:hover:bg-[#DEB887] text-white dark:text-[#1A1A1A] rounded-xl font-bold text-xs uppercase tracking-widest shadow-md hover:shadow-lg transition-all cursor-pointer"
                >
                  Simpan Puisi
                </button>
              </form>
            </div>
          </div>

          {/* Real-time Preview */}
          <div className="lg:w-1/2">
            <div className="bg-white dark:bg-[#1A1A1A] rounded-[2rem] p-8 md:p-12 shadow-sm border border-stone-100 dark:border-stone-800 sticky top-28">
              <span className="text-xs font-bold text-[#8B5E3C] dark:text-[#C9A27C] uppercase tracking-[0.3em] mb-4 block bg-[#8B5E3C]/10 dark:bg-[#C9A27C]/10 inline-block px-4 py-1.5 rounded-full">Pratinjau Nyata</span>
              
              <div className="text-center mb-10 pb-8 border-b border-stone-100 dark:border-stone-800">
                <span className="inline-block px-4 py-1.5 rounded-full bg-stone-50 dark:bg-[#151515] text-xs font-bold text-[#8B5E3C] dark:text-[#C9A27C] uppercase tracking-wider mb-6">
                  {currentCategoryName}
                </span>
                <h1 className="text-3xl md:text-4xl font-serif text-[#1A1A1A] dark:text-[#EAEAEA] tracking-tight mb-4 font-bold leading-tight">
                  {title || 'Tinta Menanti Sentuhanmu...'}
                </h1>
                <p className="text-stone-400 dark:text-stone-600 text-xs font-bold uppercase tracking-widest mt-2">
                  Oleh Anda &bull; Hari Ini
                </p>
              </div>

              {content ? (
                <div
                  className="font-serif text-lg md:text-xl leading-loose text-center text-[#1A1A1A] dark:text-[#EAEAEA] max-w-lg mx-auto quill-content"
                  dangerouslySetInnerHTML={{ __html: content }}
                />
              ) : (
                <div className="text-center py-20 text-stone-400 dark:text-stone-600 font-serif italic text-lg">
                  Mulai menulis di editor untuk melihat pratinjau puisi indahmu di sini...
                </div>
              )}
            </div>
          </div>

        </div>
      </div>
    </div>
  );
}
