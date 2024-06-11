docum9ddent.addEventListener('DOMContentLoaded', function() {
	
//	Cargar archivo
	function loadFile(filePath) {
		return fetch(filePath)
		.then(response => response.text());
	}

// Renderizar markdown a HTML
	function renderMarkdownToHTML(markdown, template) {
		const htmlContent = marked(markdown);
		const metaData = extractMetadata(markdown);
		let postHTML = tamplate.replace('{{title}}',metaData.title).replace('{{date}}',metaData.date).replace('{{content}}',htmlContent);

		return postHTML;
	}

// Extraer metadatos del Markdown
	function extractMetadata(markdown) {
		const meta = {};
		const metaPattern = /^---\n([\s\S]+?)\n---/;
		const metaMatch = markdown.match(metaPattern);

		if(metaMatch) {
			const metaString = metaMatch[1];
			metaString.split('\n').forEach(line => {
				const [key, value] = line.split(':').map(s => s.trim());
				meta[key] = value.replace(/["']/g,"");
			});
		}
		return meta;
	}

// Cargar plantilla y el archivo Markdown
	const postFile = '../blog/posts/post1.md';
	const templateFile = '../blog/templates/post-template.html';

	Promise.all([loadFile(postFile), loadFile(templateFile)])
		.then(([markdown, template]) => {
			            const postHTML = renderMarkdownToHTML(markdown, template);
			            document.documentElement.innerHTML = postHTML;
			        
		})
	        .catch(error => console.error('Error cargando los archivos:', error));
});

