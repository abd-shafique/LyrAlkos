import React from "react";
import PropTypes from "prop-types";
import { marked } from "marked";

const AnalysisResults = ({ lyrics, analysis }) => {
  const createMarkup = (content) => {
    return { __html: marked.parse(content) };
  };

  return (
    <div className="grid md:grid-cols-2 gap-8">
      <div className="bg-white rounded-lg shadow-md overflow-hidden">
        <div className="p-6">
          <h2 className="text-2xl font-bold text-gray-900 mb-4">Lyrics</h2>
          <div className="bg-gray-50 p-4 rounded-md">
            <pre className="lyrics text-gray-600 text-sm">{lyrics}</pre>
          </div>
        </div>
      </div>

      <div className="bg-white rounded-lg shadow-md overflow-hidden">
        <div className="p-6">
          <div
            className="markdown prose prose-indigo"
            dangerouslySetInnerHTML={createMarkup(analysis)}
          />
        </div>
      </div>
    </div>
  );
};

AnalysisResults.propTypes = {
  lyrics: PropTypes.string.isRequired,
  analysis: PropTypes.string.isRequired,
};

export default AnalysisResults;
