import React, { useState } from "react";
import PropTypes from "prop-types";

const SearchForm = ({ onSubmit, isLoading }) => {
  const [formData, setFormData] = useState({
    title: "",
    artist: "",
  });

  const handleSubmit = (e) => {
    e.preventDefault();
    onSubmit(formData);
  };

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData((prev) => ({
      ...prev,
      [name]: value,
    }));
  };

  return (
    <form
      onSubmit={handleSubmit}
      className="bg-white rounded-lg shadow-md p-6 mb-8"
    >
      <div className="grid md:grid-cols-2 gap-4">
        <div>
          <label
            htmlFor="title"
            className="block text-sm font-medium text-gray-700 mb-1"
          >
            Song Title
          </label>
          <input
            type="text"
            id="title"
            name="title"
            value={formData.title}
            onChange={handleChange}
            className="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            required
          />
        </div>
        <div>
          <label
            htmlFor="artist"
            className="block text-sm font-medium text-gray-700 mb-1"
          >
            Artist
          </label>
          <input
            type="text"
            id="artist"
            name="artist"
            value={formData.artist}
            onChange={handleChange}
            className="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            required
          />
        </div>
      </div>
      <button
        type="submit"
        disabled={isLoading}
        className={`w-full mt-4 px-6 py-3 text-white font-medium rounded-md transition-colors
          ${
            isLoading
              ? "bg-indigo-400 cursor-not-allowed"
              : "bg-indigo-600 hover:bg-indigo-700"
          }`}
      >
        {isLoading ? "Analyzing..." : "Analyze Lyrics"}
      </button>
    </form>
  );
};

SearchForm.propTypes = {
  onSubmit: PropTypes.func.isRequired,
  isLoading: PropTypes.bool.isRequired,
};

export default SearchForm;
