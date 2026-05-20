import React, { useState, useEffect, useRef } from 'react';
import { useParams, useNavigate, Link } from 'react-router-dom';
import { getPoemBySlug, toggleLike, getComments, addComment, deleteComment, getCurrentUser } from '../mockDb';
import { Heart, Eye, MessageSquare, Share2, CornerUpLeft, Maximize2, Minimize2, Trash2, X } from 'lucide-react';

export default function PoemDetail() {
  const { slug } = useParams();
  const navigate = useNavigate();
  const commentInputRef = useRef(null);
  
  const [poem, setPoem] = useState(null);
  const [comments, setComments] = useState([]);
  const [newComment, setNewComment] = useState('');
  const [isLiked, setIsLiked] = useState(false);
  const [likesCount, setLikesCount] = useState(0);
  const [commentsCount, setCommentsCount] = useState(0);
  const [currentUser] = useState(getCurrentUser());
  const [likersModalOpen, setLikersModalOpen] = useState(false);
  const [focusMode, setFocusMode] = useState(false);

  useEffect(() => {
    const loadedPoem = getPoemBySlug(slug);
    if (!loadedPoem) { navigate('/poems'); return; }
    setPoem(loadedPoem);
    const loadedComments = getComments(loadedPoem.id);
    setComments(loadedComments);
    setLikesCount(loadedPoem.likes_count);
    setCommentsCount(loadedComments.length);
    if (currentUser) {
      setIsLiked(loadedPoem.likers.some(l => l.id === currentUser.id));
    }
  }, [slug, currentUser, navigate]);

  const handleLikeToggle = () => {
    if (!currentUser) { navigate('/login'); return; }
    const success = toggleLike(poem.id);
    if (success) {
      setIsLiked(!isLiked);
      setLikesCount(prev => isLiked ? prev - 1 : prev + 1);
      setTimeout(() => {
        const p = getPoemBySlug(slug);
        if (p) setPoem(p);
      }, 100);
    }
  };

  const handleCommentSubmit = (e) => {
    e.preventDefault();
    if (!newComment.trim()) return;
    const comment = addComment(poem.id, newComment);
    if (comment) {
      setComments(prev => [comment, ...prev]);
      setCommentsCount(prev => prev + 1);
      setNewComment('');
    }
  };

  const handleCommentDelete = (commentId) => {
    if (window.confirm('Apakah Anda yakin ingin menghapus komentar ini?')) {
      deleteComment(commentId);
      setComments(prev => prev.filter(c => c.id !== commentId));
      setCommentsCount(prev => prev - 1);
    }
  };

  const handleShare = () => {
    if (navigator.share) {
      navigator.share({
        title: `${poem.title} oleh ${poem.writer.name}`,
        text: `Baca puisi "${poem.title}" di RuangKata.`,
        url: window.location.href
      }).catch(console.error);
    } else {
      navigator.clipboard.writeText(window.location.href).then(() => {
        alert('Tautan puisi berhasil disalin ke clipboard!');
      });
    }
  };

  if (!poem) return null;

  return (
    <article className="bg-[#F8F6F2] dark:bg-[#0F0F0F] min-h-screen pt-8 pb-24 transition-colors duration-300">
      <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {/* Top Controls */}
        {!focusMode && (
          <div className="mb-8 flex items-center justify-between">
            <button
              onClick={() => navigate(-1)}
              className="inline-flex items-center gap-2 text-sm font-bold uppercase tracking-widest text-stone-600 dark:text-stone-300 hover:text-[#8B5E3C] dark:hover:text-[#C9A27C] transition-colors bg-white dark:bg-[#1A1A1A] px-5 py-2.5 rounded-full shadow-sm border border-stone-200 dark:border-stone-800 hover:shadow-md cursor-pointer"
            >
              <CornerUpLeft className="h-4 w-4" />
              Kembali
            </button>
            
            <button
              onClick={() => setFocusMode(true)}
              className="inline-flex items-center gap-2 text-sm font-bold uppercase tracking-widest text-stone-600 dark:text-stone-300 hover:text-[#8B5E3C] dark:hover:text-[#C9A27C] transition-colors bg-white dark:bg-[#1A1A1A] px-5 py-2.5 rounded-full shadow-sm border border-stone-200 dark:border-stone-800 hover:shadow-md cursor-pointer"
            >
              <Maximize2 className="h-4 w-4" />
              Mode Fokus
            </button>
          </div>
        )}

        {focusMode && (
          <div className="fixed top-8 right-8 z-[90]">
            <button
              onClick={() => setFocusMode(false)}
              className="inline-flex items-center gap-2 text-sm font-bold uppercase tracking-widest text-stone-600 dark:text-stone-300 hover:text-[#8B5E3C] dark:hover:text-[#C9A27C] transition-colors bg-white dark:bg-[#1A1A1A] px-5 py-2.5 rounded-full shadow-lg border border-stone-200 dark:border-stone-800 cursor-pointer"
            >
              <Minimize2 className="h-4 w-4" />
              Keluar Fokus
            </button>
          </div>
        )}

        {/* Poem Card */}
        <div className={`transition-all duration-500 ${
          focusMode 
            ? 'shadow-none bg-transparent border-transparent p-4 md:p-8 max-w-2xl mx-auto'
            : 'bg-white dark:bg-[#1A1A1A] rounded-[2rem] p-8 md:p-16 shadow-lg border border-stone-100 dark:border-stone-800'
        }`}>
          <header className="text-center mb-16">
            <span className="inline-block px-4 py-1.5 rounded-full bg-stone-100 dark:bg-[#151515] text-xs font-bold text-[#8B5E3C] dark:text-[#C9A27C] uppercase tracking-wider mb-6">
              {poem.category.name}
            </span>
            <h1 className="text-4xl md:text-5xl lg:text-6xl font-serif text-[#1A1A1A] dark:text-[#EAEAEA] tracking-tight mb-8 leading-tight transition-colors font-bold">
              {poem.title}
            </h1>
            <div className="flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-8 text-stone-500 dark:text-stone-400 border-b border-stone-100 dark:border-stone-800 pb-8 transition-colors">
              <span className="flex items-center gap-3 bg-stone-50 dark:bg-[#151515] pr-5 rounded-full">
                <div className="w-10 h-10 rounded-full bg-stone-200 dark:bg-stone-800 text-stone-700 dark:text-stone-300 flex items-center justify-center font-serif text-lg font-bold shadow-sm">
                  {poem.writer.name.charAt(0)}
                </div>
                <span className="font-bold text-sm sm:text-base">{poem.writer.name}</span>
              </span>
              <div className="flex items-center gap-3 text-[10px] font-bold uppercase tracking-widest">
                <span className="flex items-center gap-1.5 bg-stone-50 dark:bg-[#151515] px-4 py-2 rounded-full">
                  {new Date(poem.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })}
                </span>
                <span className="flex items-center gap-1.5 bg-stone-50 dark:bg-[#151515] px-4 py-2 rounded-full">
                  <Eye className="h-4 w-4" />
                  {poem.views || 42}
                </span>
              </div>
            </div>
          </header>

          {/* Poem Content */}
          <div 
            className="font-serif text-xl md:text-2xl leading-loose whitespace-pre-line text-[#1A1A1A] dark:text-[#EAEAEA] max-w-2xl mx-auto quill-content"
            dangerouslySetInnerHTML={{ __html: poem.content }}
          />

          {/* Interactions */}
          {!focusMode && (
            <div className="mt-12 flex flex-wrap justify-center items-center gap-4 border-t border-stone-100 dark:border-stone-800 pt-10">
              <div className="flex items-center bg-stone-50 dark:bg-[#151515] rounded-full overflow-hidden shadow-sm">
                <button
                  onClick={handleLikeToggle}
                  className={`flex items-center gap-2 hover:text-rose-500 transition-colors px-6 py-3 border-r border-stone-200 dark:border-stone-800 cursor-pointer ${
                    isLiked ? 'text-rose-500' : 'text-stone-500 dark:text-stone-400'
                  }`}
                >
                  <Heart className={`h-5 w-5 transition-transform ${isLiked ? 'fill-current scale-110' : 'hover:scale-110'}`} />
                  <span className="font-bold font-sans">{likesCount}</span>
                </button>
                {likesCount > 0 && (
                  <button
                    onClick={() => setLikersModalOpen(true)}
                    className="px-4 py-3 text-[10px] font-bold uppercase tracking-widest text-stone-500 hover:text-[#8B5E3C] dark:hover:text-[#C9A27C] transition-colors cursor-pointer"
                  >
                    Lihat
                  </button>
                )}
              </div>

              <button
                onClick={() => commentInputRef.current?.focus()}
                className="flex items-center gap-2 text-stone-500 dark:text-stone-400 hover:text-sky-500 transition-colors bg-stone-50 dark:bg-[#151515] px-6 py-3 rounded-full shadow-sm cursor-pointer"
              >
                <MessageSquare className="h-5 w-5" />
                <span className="font-bold font-sans">{commentsCount}</span>
              </button>

              <button
                onClick={handleShare}
                className="flex items-center gap-2 text-stone-500 dark:text-stone-400 hover:text-[#8B5E3C] dark:hover:text-[#C9A27C] transition-colors bg-stone-50 dark:bg-[#151515] px-6 py-3 rounded-full shadow-sm cursor-pointer"
              >
                <Share2 className="h-5 w-5" />
                <span className="font-bold uppercase text-[10px] tracking-widest">Bagikan</span>
              </button>
            </div>
          )}
        </div>

        {/* Comments Section */}
        {!focusMode && (
          <div className="mt-12 max-w-3xl mx-auto">
            <h3 className="text-xl font-serif font-bold text-[#1A1A1A] dark:text-[#EAEAEA] mb-8 flex items-center gap-2">
              Komentar <span className="bg-stone-200 dark:bg-stone-800 text-stone-600 dark:text-stone-400 text-sm px-3 py-1 rounded-full font-sans">{commentsCount}</span>
            </h3>

            {/* Comment Form */}
            {currentUser ? (
              <form onSubmit={handleCommentSubmit} className="mb-12 flex gap-4">
                <div className="flex-shrink-0">
                  <div className="w-10 h-10 rounded-full bg-[#8B5E3C] text-white flex items-center justify-center font-bold text-sm shadow-sm">
                    {currentUser.name.charAt(0)}
                  </div>
                </div>
                <div className="flex-grow">
                  <textarea
                    ref={commentInputRef}
                    value={newComment}
                    onChange={(e) => setNewComment(e.target.value)}
                    rows="2"
                    className="w-full bg-white dark:bg-[#1A1A1A] border border-stone-200 dark:border-stone-800 rounded-2xl px-4 py-3 text-[#1A1A1A] dark:text-[#EAEAEA] focus:ring-2 focus:ring-[#8B5E3C] focus:border-transparent transition-all resize-none shadow-sm placeholder-stone-400"
                    placeholder="Tuliskan apresiasi atau pemikiranmu..."
                    required
                  ></textarea>
                  <div className="mt-2 flex justify-end">
                    <button type="submit" className="bg-[#8B5E3C] hover:bg-[#704B30] dark:bg-[#C9A27C] dark:text-[#1A1A1A] dark:hover:bg-[#DEB887] text-white px-6 py-2 rounded-full font-bold text-[10px] uppercase tracking-widest shadow-md hover:shadow-lg transition-all cursor-pointer">
                      Kirim Komentar
                    </button>
                  </div>
                </div>
              </form>
            ) : (
              <div className="mb-12 bg-white dark:bg-[#1A1A1A] p-6 rounded-[2rem] border border-stone-100 dark:border-stone-800 shadow-sm text-center">
                <p className="text-stone-500 dark:text-stone-400 mb-4 font-serif italic">Masuk untuk ikut berdiskusi dan memberikan apresiasi.</p>
                <Link to="/login" className="inline-block bg-[#8B5E3C] dark:bg-[#C9A27C] dark:text-[#1A1A1A] text-white px-6 py-2 rounded-full font-bold text-[10px] uppercase tracking-widest hover:bg-[#704B30] transition-colors shadow-md">Masuk</Link>
              </div>
            )}

            {/* Comment List */}
            <div className="space-y-6">
              {comments.map((comment) => (
                <div key={comment.id} className="bg-white dark:bg-[#1A1A1A] p-6 rounded-[2rem] shadow-sm border border-stone-100 dark:border-stone-800 flex gap-4 transition-all hover:shadow-md">
                  <div className="flex-shrink-0">
                    <div className="w-10 h-10 rounded-full bg-stone-200 dark:bg-[#151515] border border-stone-100 dark:border-stone-800 text-stone-700 dark:text-stone-300 flex items-center justify-center font-bold text-sm">
                      {comment.user.name.charAt(0)}
                    </div>
                  </div>
                  <div className="flex-grow">
                    <div className="flex items-center justify-between mb-1">
                      <div>
                        <span className="font-bold text-[#1A1A1A] dark:text-[#EAEAEA]">{comment.user.name}</span>
                        <span className="text-[10px] text-stone-400 uppercase tracking-widest ml-2">
                          {new Date(comment.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short' })}
                        </span>
                      </div>
                      {currentUser && currentUser.id === comment.user_id && (
                        <button
                          onClick={() => handleCommentDelete(comment.id)}
                          className="text-stone-400 hover:text-red-500 transition-colors p-1 cursor-pointer"
                          title="Hapus komentar"
                        >
                          <Trash2 className="h-4 w-4" />
                        </button>
                      )}
                    </div>
                    <p className="text-stone-700 dark:text-stone-300 leading-relaxed font-sans text-sm whitespace-pre-line">{comment.content}</p>
                  </div>
                </div>
              ))}
              {comments.length === 0 && (
                <div className="text-center py-10 bg-white dark:bg-[#1A1A1A] rounded-[2rem] border border-stone-100 dark:border-stone-800">
                  <p className="text-stone-400 font-serif italic text-lg">Belum ada komentar. Jadilah yang pertama memberikan apresiasi!</p>
                </div>
              )}
            </div>
          </div>
        )}

      </div>

      {/* Likers Modal */}
      {likersModalOpen && (
        <div className="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6">
          <div className="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onClick={() => setLikersModalOpen(false)}></div>
          
          <div className="bg-white dark:bg-[#1A1A1A] rounded-[2rem] shadow-2xl w-full max-w-md relative z-10 overflow-hidden transform transition-all">
            <div className="px-6 py-4 border-b border-stone-100 dark:border-stone-800 flex justify-between items-center bg-stone-50 dark:bg-[#151515]">
              <h3 className="font-bold text-[#1A1A1A] dark:text-[#EAEAEA] uppercase tracking-widest text-sm">Menyukai Puisi Ini</h3>
              <button onClick={() => setLikersModalOpen(false)} className="text-stone-400 hover:text-[#1A1A1A] dark:hover:text-[#EAEAEA] transition-colors p-1 bg-white dark:bg-[#1A1A1A] rounded-full shadow-sm cursor-pointer">
                <X className="h-5 w-5" />
              </button>
            </div>
            <div className="max-h-[60vh] overflow-y-auto p-2">
              {poem.likers && poem.likers.map((liker) => (
                <div key={liker.id} className="flex items-center gap-3 p-4 hover:bg-stone-50 dark:hover:bg-[#151515] rounded-[1.5rem] transition-colors">
                  <div className="w-10 h-10 rounded-full bg-stone-200 dark:bg-stone-800 text-stone-700 dark:text-stone-300 flex items-center justify-center font-bold text-sm border border-stone-100 dark:border-stone-800">
                    {liker.name.charAt(0)}
                  </div>
                  <div>
                    <h4 className="font-bold text-sm text-[#1A1A1A] dark:text-[#EAEAEA]">{liker.name}</h4>
                    <p className="text-[10px] text-stone-500 uppercase tracking-widest mt-0.5">Penyair</p>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </div>
      )}
    </article>
  );
}
