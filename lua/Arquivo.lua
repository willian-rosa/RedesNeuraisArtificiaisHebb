RedeNeural.Arquivo = {};


function RedeNeural.Arquivo:pastaArquivo()
	return ''
end

function RedeNeural.Arquivo:_buscarConteudoArquivo(nomeArquivo)

	local conteudo = ''
	local file = io.open(nomeArquivo)
	
	if file then
		line = ''
		repeat 
			conteudo = conteudo..line
			line = file:read()
		until line == nil
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


--[[
buscarConteudoArquivo
scanear
buscarArquivosClassificacao
]]

local re = RedeNeural.Arquivo:_scanear('treino')
print(re)