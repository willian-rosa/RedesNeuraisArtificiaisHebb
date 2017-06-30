RedeNeural.Arquivo = {};


function RedeNeural.Arquivo:pastaArquivo()
	return ''
end

function RedeNeural.Arquivo:_buscarConteudoArquivo(nomeArquivo)

	local conteudo = ''
	local file = io.open(nomeArquivo)
	
	if file then
		conteudo = file:read('*a')
	end

	return conteudo

end

function RedeNeural.Arquivo:_scanear(pastaSeleciona)
	local files = {}
	local i = 0

	local p = io.popen('find "'..pastaSeleciona..'" -type f')
	for file in p:lines() do
		files[i] = file
		i = i + 1
	end

	return files;

end

function RedeNeural.Arquivo:_buscarArquivos(nomePasta)
	local entradas = {}
	local arquivos = self:_scanear(nomePasta)
	for pos, val in pairs(arquivos) do
		entradas[pos] = self:_buscarConteudoArquivo(val)
	end
	return entradas
end

function RedeNeural.Arquivo:buscarArquivosTreinamento()
	return self:_buscarArquivos('treino')
end

function RedeNeural.Arquivo:buscarArquivosClassificacao()
	return self:_buscarArquivos('classificacao')
end