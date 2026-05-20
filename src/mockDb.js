```js
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

const initialUsers = [];

const initialPoems = [];

const initialLikes = [];

const initialComments = [];

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
}
```
