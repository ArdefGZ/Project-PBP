import React, { useState, useEffect } from 'react';

function BookList() {
  const [books, setBooks] = useState([]);
  const [totalRows, setTotalRows] = useState(0);

  useEffect(() => {
    // Fetch data from the server when the component mounts
    fetchData();
  }, []);

  const fetchData = () => {
    // Build the API URL with your server's endpoint
    const apiUrl = '/api/books';

    // Log the query to the console
    console.log('API Query:', apiUrl);

    // Make a GET request to the server's API
    fetch(apiUrl)
      .then((response) => response.json())
      .then((data) => {
        setBooks(data);
        setTotalRows(data.length);
      })
      .catch((error) => {
        console.error('Error fetching data:', error);
      });
  };


  const handleSearchChange = (e) => {
    setSearchValue(e.target.value.toLowerCase());
  };

  const handleCategoryChange = (e) => {
    setCategoryValue(e.target.value);
  };

  const handlePriceRangeChange = (e) => {
    setPriceRangeValue(e.target.value);
  };

  return (
    <main className="table">
      <section className="table__header">
        <h1 style={{ fontSize: '24px' }}>Book's Data</h1>
        <div className="input-group">
          <input
            type="search"
            id="search"
            placeholder="Search..."
            value={searchValue}
            onChange={handleSearchChange}
          />
        </div>
        {/* Add Book Data, Rekap Data, Show Cart, and Order buttons */}
        {/* Export options */}
      </section>
      <section className="table__body">
        <div className="mb-3">
          <label htmlFor="categorySelect">Category:</label>
          <select
            className="form-select"
            id="categorySelect"
            value={categoryValue}
            onChange={handleCategoryChange}
          >
            {/* Options */}
          </select>
        </div>
        <div className="mb-3">
          <label htmlFor="priceRange">Price Range:</label>
          <select
            className="form-select"
            id="priceRange"
            value={priceRangeValue}
            onChange={handlePriceRangeChange}
          >
            {/* Options */}
          </select>
        </div>
        <table id="bookTable">
          <thead>
            <tr>
              <th>ISBN</th>
              <th>Author</th>
              <th>Category</th>
              <th>Title</th>
              <th>Price</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            {books.map((book) => (
              <tr key={book.isbn} data-isbn={book.isbn}>
                <td>{book.isbn}</td>
                <td>{book.author}</td>
                <td>{book.category}</td>
                <td>{book.title}</td>
                <td>{book.price}</td>
                <td>
                  <a href={`review_book.php?id=${book.isbn}`}>Review</a>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
        <p id="totalRows">Total Rows = {totalRows}</p>
        {/* JavaScript code for filtering */}
      </section>
    </main>
  );
}

export default BookList;
