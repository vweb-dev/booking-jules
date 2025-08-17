const Http = {
    /**
     * Performs a GET request.
     * @param {string} url The URL to fetch.
     * @returns {Promise<any>} A promise that resolves with the JSON response.
     */
    get: async (url) => {
        try {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return await response.json();
        } catch (error) {
            console.error("Fetch error:", error);
            throw error;
        }
    }
};
