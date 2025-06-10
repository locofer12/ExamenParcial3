self.onmessage = function (e) {
    try {
        const data = e.data;
        if (!Array.isArray(data)) throw new Error("No es un arreglo válido");
        data.sort((a, b) => a - b);
        self.postMessage(data.slice(0, 50)); // Enviar solo los primeros 50 ordenados
    } catch (err) {
        self.postMessage({ error: err.message });
    }
};
