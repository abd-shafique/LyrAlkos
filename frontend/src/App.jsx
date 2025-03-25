import React, { useState } from "react";
import SearchForm from "./components/SearchForm";
import AnalysisResults from "./components/AnalysisResults";
import ErrorMessage from "./components/ErrorMessage";
import { lyricsService } from "./services/lyricsService";

function App() {
  const [result, setResult] = useState(null);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  const handleSubmit = async (formData) => {
    setLoading(true);
    setError(null);
    setResult(null);

    try {
      const data = await lyricsService.analyzeSong(
        formData.title,
        formData.artist
      );
      setResult(data);
    } catch (err) {
      setError(err.message);
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="min-h-screen p-4 md:p-8">
      <div className="max-w-6xl mx-auto">
        <header className="text-center mb-12">
          <h1 className="text-4xl md:text-5xl font-bold text-indigo-600 mb-4">
            LyrAlkos
          </h1>
          <p className="text-gray-600 text-lg">
            Discover the deeper meaning behind your favorite songs
          </p>
        </header>

        <SearchForm onSubmit={handleSubmit} isLoading={loading} />

        {error && <ErrorMessage message={error} />}

        {result && (
          <AnalysisResults lyrics={result.lyrics} analysis={result.analysis} />
        )}
      </div>
    </div>
  );
}

export default App;
