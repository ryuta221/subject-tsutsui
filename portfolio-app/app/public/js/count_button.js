function countGrapheme(string) {
    // 漢字は一文字カウント
    const segmenter = new Intl.Segmenter("ja", { granularity: "grapheme" });
    return [...segmenter.segment(string)].length;
}