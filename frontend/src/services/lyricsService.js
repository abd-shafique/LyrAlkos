import axios from "axios";

const API_BASE_URL = "/api";

export const lyricsService = {
  async analyzeSong(title, artist) {
    try {
      const response = await axios.post(`${API_BASE_URL}/analyze`, {
        title,
        artist,
      });
      return response.data;
    } catch (error) {
      if (error.response) {
        throw new Error(error.response.data.error || "Failed to analyze song");
      }
      throw new Error("Network error occurred");
    }
  },
};

export default lyricsService;
