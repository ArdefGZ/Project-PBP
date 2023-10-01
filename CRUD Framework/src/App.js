import React from 'react';
import './App.css'; // Import any custom CSS if needed
import BookList from './components/BookList.jsx'; // Import the BookList component

function App() {
  return (
    <div className="App">
      {/* Your application content */}
      <BookList /> {/* Use the BookList component */}
    </div>
  );
}

export default App;
