const getYouTubeVideoId = (url) => {
    if (!url) return null;

    try {
        const parsedUrl = new URL(url);

        // Example: https://youtu.be/BUctsGfaXiM
        if (parsedUrl.hostname === "youtu.be") {
            return parsedUrl.pathname.replace("/", "");
        }

        // Example: https://www.youtube.com/watch?v=BUctsGfaXiM
        if (parsedUrl.searchParams.get("v")) {
            return parsedUrl.searchParams.get("v");
        }

        // Example: https://www.youtube.com/embed/BUctsGfaXiM
        if (parsedUrl.pathname.includes("/embed/")) {
            return parsedUrl.pathname.split("/embed/")[1];
        }

        // Example: https://www.youtube.com/shorts/BUctsGfaXiM
        if (parsedUrl.pathname.includes("/shorts/")) {
            return parsedUrl.pathname.split("/shorts/")[1];
        }

        return null;
    } catch (error) {
        console.error("Invalid YouTube URL:", error);
        return null;
    }
};

export default getYouTubeVideoId;