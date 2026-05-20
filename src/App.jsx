import React, { useEffect } from 'react';
import { Routes, Route, Navigate } from 'react-router-dom';
import { initDb, getCurrentUser } from './mockDb';
import Navbar from './components/Navbar';
import Footer from './components/Footer';

// Pages
import Welcome from './pages/Welcome';
import PoemList from './pages/PoemList';
import PoemDetail from './pages/PoemDetail';
import Writers from './pages/Writers';
import Login from './pages/Login';
import Dashboard from './pages/Dashboard';
import PoemCreate from './pages/PoemCreate';
import PoemEdit from './pages/PoemEdit';
import ProfileEdit from './pages/ProfileEdit';

function ProtectedRoute({ children }) {
  const user = getCurrentUser();
  if (!user) {
    return <Navigate to="/login" replace />;
  }
  return children;
}

export default function App() {
  useEffect(() => {
    initDb();
  }, []);

  return (
    <div className="min-h-screen flex flex-col bg-[#F8F6F2] dark:bg-[#0A0A0A] text-[#1A1A1A] dark:text-[#EAEAEA] transition-colors duration-300">
      <Navbar />
      <main className="flex-grow">
        <Routes>
          <Route path="/" element={<Welcome />} />
          <Route path="/poems" element={<PoemList />} />
          <Route path="/poems/:slug" element={<PoemDetail />} />
          <Route path="/writers" element={<Writers />} />
          <Route path="/login" element={<Login />} />
          
          {/* Protected Dashboard Routes */}
          <Route path="/dashboard" element={
            <ProtectedRoute>
              <Dashboard />
            </ProtectedRoute>
          } />
          <Route path="/dashboard/poems/create" element={
            <ProtectedRoute>
              <PoemCreate />
            </ProtectedRoute>
          } />
          <Route path="/dashboard/poems/edit/:slug" element={
            <ProtectedRoute>
              <PoemEdit />
            </ProtectedRoute>
          } />
          <Route path="/dashboard/profile" element={
            <ProtectedRoute>
              <ProfileEdit />
            </ProtectedRoute>
          } />

          {/* Catch-all redirect to welcome */}
          <Route path="*" element={<Navigate to="/" replace />} />
        </Routes>
      </main>
      <Footer />
    </div>
  );
}
