// Initial mock data
const initialCategories = [
  { id: 1, name: "Asmara", slug: "asmara" },
  { id: 2, name: "Refleksi", slug: "refleksi" },
  { id: 3, name: "Filosofi", slug: "filosofi" },
  { id: 4, name: "Sosial", slug: "sosial" },
  { id: 5, name: "Kehidupan", slug: "kehidupan" },
  { id: 6, name: "Alam", slug: "alam" },
  { id: 7, name: "Kesedihan", slug: "kesedihan" },
  { id: 8, name: "Harapan", slug: "harapan" }
];

const initialUsers = [
  { id: 1, name: "Fauzan Raka", email: "fauzan@ruangkata.com", avatar: null, bio: "Penyair sunyi yang gemar merangkai rindu.", role: "peserta" },
  { id: 2, name: "Siti Rahma", email: "siti@ruangkata.com", avatar: null, bio: "Pengagum senja dan aksara.", role: "peserta" },
  { id: 3, name: "Budi Santoso", email: "budi@ruangkata.com", avatar: null, bio: "Menulis untuk abadi.", role: "peserta" }
];

const initialPoems = [
  {
    id: 1,
    title: "Deru Debu di Batas Kota",
    slug: "deru-debu-di-batas-kota-1024",
    category_id: 5,
    user_id: 1,
    content: "<p>Klakson menyalak bersahut-sahutan<br>Debu-debu berterbangan menyentuh impian<br>Di batas kota ini, kita bertaruh kehidupan<br>Mengejar mimpi yang tak kunjung padam.</p>",
    excerpt: "Sebuah kontemplasi tentang kerasnya kehidupan urban di batas kota.",
    status: "published",
    published_at: "2026-05-18T10:00:00Z",
    created_at: "2026-05-18T10:00:00Z"
  },
  {
    id: 2,
    title: "Sketsa Rindu Sendu",
    slug: "sketsa-rindu-sendu-2048",
    category_id: 1,
    user_id: 2,
    content: "<p>Kukira rindu itu manis bagai madu<br>Ternyata pahit menyayat kalbu<br>Melukis wajahmu di langit kelabu<br>Menanti pelukan yang tak kunjung menyatu.</p>",
    excerpt: "Rangkaian bait puitis tentang kerinduan yang terhalang jarak dan waktu.",
    status: "published",
    published_at: "2026-05-19T02:00:00Z",
    created_at: "2026-05-19T02:00:00Z"
  },
  {
    id: 3,
    title: "Filosofi Daun Kering",
    slug: "filosofi-daun-kering-3072",
    category_id: 3,
    user_id: 3,
    content: "<p>Gugur satu tumbuh seribu<br>Pasrah jatuh ditiup bayu<br>Tak pernah membenci angin yang berlalu<br>Sebab ia tahu, jalannya telah digariskan begitu.</p>",
    excerpt: "Belajar tentang keikhlasan dan takdir dari selembar daun kering.",
    status: "published",
    published_at: "2026-05-19T08:00:00Z",
    created_at: "2026-05-19T08:00:00Z"
  }
];

const initialLikes = [
  { user_id: 2, poem_id: 1 },
  { user_id: 3, poem_id: 1 },
  { user_id: 1, poem_id: 2 }
];

const initialComments = [
  { id: 1, poem_id: 1, user_id: 2, content: "Sangat mendalam! Terasa sekali suasana hiruk pikuk kotanya.", created_at: "2026-05-18T11:30:00Z" },
  { id: 2, poem_id: 1, user_id: 3, content: "Karya yang luar biasa, diksi yang dipilih sangat kuat.", created_at: "2026-05-18T12:00:00Z" }
];

export function initDb() {
  if (!localStorage.getItem("rk_categories")) {
    localStorage.setItem("rk_categories", JSON.stringify(initialCategories));
  }
  if (!localStorage.getItem("rk_users")) {
    localStorage.setItem("rk_users", JSON.stringify(initialUsers));
  }
  if (!localStorage.getItem("rk_poems")) {
    localStorage.setItem("rk_poems", JSON.stringify(initialPoems));
  }
  if (!localStorage.getItem("rk_likes")) {
    localStorage.setItem("rk_likes", JSON.stringify(initialLikes));
  }
  if (!localStorage.getItem("rk_comments")) {
    localStorage.setItem("rk_comments", JSON.stringify(initialComments));
  }
  
  // Set current user (logged in user)
  if (!localStorage.getItem("rk_current_user")) {
    localStorage.setItem("rk_current_user", JSON.stringify(initialUsers[0])); // Fauzan Raka
  }
}

// Helpers
export function getCategories() {
  return JSON.parse(localStorage.getItem("rk_categories") || "[]");
}

export function getUsers() {
  return JSON.parse(localStorage.getItem("rk_users") || "[]");
}

export function getCurrentUser() {
  const user = localStorage.getItem("rk_current_user");
  return user ? JSON.parse(user) : null;
}

export function setCurrentUser(user) {
  if (user) {
    localStorage.setItem("rk_current_user", JSON.stringify(user));
  } else {
    localStorage.removeItem("rk_current_user");
  }
}

export function getPoems() {
  const poems = JSON.parse(localStorage.getItem("rk_poems") || "[]");
  const users = getUsers();
  const categories = getCategories();
  const likes = getLikes();
  
  return poems.map(p => {
    const writer = users.find(u => u.id === p.user_id) || { name: "Anonim", bio: "" };
    const category = categories.find(c => c.id === p.category_id) || { name: "Lainnya" };
    const poemLikes = likes.filter(l => l.poem_id === p.id);
    
    return {
      ...p,
      writer,
      category,
      likes_count: poemLikes.length,
      likers: poemLikes.map(l => users.find(u => u.id === l.user_id)).filter(Boolean)
    };
  }).filter(p => p.status === "published");
}

export function getMyPoems() {
  const poems = JSON.parse(localStorage.getItem("rk_poems") || "[]");
  const currentUser = getCurrentUser();
  if (!currentUser) return [];
  return poems.filter(p => p.user_id === currentUser.id);
}

export function getPoemBySlug(slug) {
  const poems = getPoems();
  const poem = poems.find(p => p.slug === slug);
  if (!poem) {
    // Try my draft poems too
    const myPoems = getMyPoems();
    const myPoem = myPoems.find(p => p.slug === slug);
    if (myPoem) {
      const users = getUsers();
      const categories = getCategories();
      const likes = getLikes();
      const writer = users.find(u => u.id === myPoem.user_id) || { name: "Anonim" };
      const category = categories.find(c => c.id === myPoem.category_id) || { name: "Lainnya" };
      const poemLikes = likes.filter(l => l.poem_id === myPoem.id);
      return {
        ...myPoem,
        writer,
        category,
        likes_count: poemLikes.length,
        likers: poemLikes.map(l => users.find(u => u.id === l.user_id)).filter(Boolean)
      };
    }
  }
  return poem;
}

export function getLikes() {
  return JSON.parse(localStorage.getItem("rk_likes") || "[]");
}

export function toggleLike(poemId) {
  const currentUser = getCurrentUser();
  if (!currentUser) return false;
  
  let likes = getLikes();
  const index = likes.findIndex(l => l.poem_id === poemId && l.user_id === currentUser.id);
  
  if (index > -1) {
    likes.splice(index, 1);
  } else {
    likes.push({ poem_id: poemId, user_id: currentUser.id });
  }
  
  localStorage.setItem("rk_likes", JSON.stringify(likes));
  return true;
}

export function getComments(poemId) {
  const comments = JSON.parse(localStorage.getItem("rk_comments") || "[]");
  const users = getUsers();
  return comments
    .filter(c => c.poem_id === poemId)
    .map(c => ({
      ...c,
      user: users.find(u => u.id === c.user_id) || { name: "Anonim" }
    }))
    .sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
}

export function addComment(poemId, content) {
  const currentUser = getCurrentUser();
  if (!currentUser) return null;
  
  const comments = JSON.parse(localStorage.getItem("rk_comments") || "[]");
  const newComment = {
    id: Date.now(),
    poem_id: poemId,
    user_id: currentUser.id,
    content,
    created_at: new Date().toISOString()
  };
  
  comments.push(newComment);
  localStorage.setItem("rk_comments", JSON.stringify(comments));
  return {
    ...newComment,
    user: currentUser
  };
}

export function deleteComment(commentId) {
  let comments = JSON.parse(localStorage.getItem("rk_comments") || "[]");
  comments = comments.filter(c => c.id !== commentId);
  localStorage.setItem("rk_comments", JSON.stringify(comments));
}

export function savePoem(poemData) {
  const currentUser = getCurrentUser();
  if (!currentUser) return null;
  
  const poems = JSON.parse(localStorage.getItem("rk_poems") || "[]");
  const slug = (poemData.title.toLowerCase().replace(/[^a-z0-9]+/g, "-").replace(/(^-|-$)/g, "")) + "-" + Math.floor(1000 + Math.random() * 9000);
  
  const newPoem = {
    id: poemData.id || Date.now(),
    title: poemData.title,
    slug: poemData.id ? poemData.slug : slug,
    category_id: parseInt(poemData.category_id),
    user_id: currentUser.id,
    content: poemData.content,
    excerpt: poemData.excerpt,
    status: poemData.status,
    published_at: poemData.status === 'published' ? new Date().toISOString() : null,
    created_at: poemData.created_at || new Date().toISOString()
  };
  
  if (poemData.id) {
    const index = poems.findIndex(p => p.id === poemData.id);
    if (index > -1) {
      poems[index] = newPoem;
    }
  } else {
    poems.push(newPoem);
  }
  
  localStorage.setItem("rk_poems", JSON.stringify(poems));
  return newPoem;
}

export function deletePoem(poemId) {
  let poems = JSON.parse(localStorage.getItem("rk_poems") || "[]");
  poems = poems.filter(p => p.id !== poemId);
  localStorage.setItem("rk_poems", JSON.stringify(poems));
}

export function registerUser(name, email, password) {
  const users = getUsers();
  const exists = users.find(u => u.email === email);
  if (exists) return null;
  
  const newUser = {
    id: Date.now(),
    name,
    email,
    avatar: null,
    bio: "",
    role: "peserta"
  };
  
  users.push(newUser);
  localStorage.setItem("rk_users", JSON.stringify(users));
  setCurrentUser(newUser);
  return newUser;
}

export function loginUser(email, password) {
  const users = getUsers();
  const user = users.find(u => u.email === email);
  if (user) {
    setCurrentUser(user);
    return user;
  }
  // If not exists, auto-create a mock user to simplify login flow!
  const name = email.split('@')[0].replace('.', ' ');
  const newUser = registerUser(name, email, password);
  return newUser;
}
