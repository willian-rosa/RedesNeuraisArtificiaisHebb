RedeNeural.Hebb = {}
RedeNeural.Hebb._rede = nil

function RedeNeural.Hebb._limpar(obj)
	for i = 1, obj:size(2) do
		obj[1][i] = 0
	end
end

function RedeNeural.Hebb._limparBias(obj)
	obj[1] = 0;
end

function RedeNeural.Hebb._decodificarArquivo(arquivo)
	local chars = split(arquivo, '')
	local values = {}
	local j = 0
	for i = 0, #chars do
		local char = chars[i];
		if char ~= '\n' and char ~= '\r' then
			if char == '#' then 
				values[j] = -1
			elseif char == '.' then 
				values[j] = 1
			else
				values[j] = 0
			end
			j = j+1
		end
	end

	return values;

end

function RedeNeural.Hebb:treinar()

	local rede 			= nn.Sequential();
	local criterio 		= nn.MSECriterion()

	local quantidadeNeuronioEntrada = 25;
	local quantidadeNeuronioSaida = 1;
	local camada = 1;


	local modeloEntrada	= nn.Linear(quantidadeNeuronioEntrada, quantidadeNeuronioSaida);
	local modeloSaida	= nn.Linear(camada, quantidadeNeuronioSaida);

	rede:add(modeloEntrada)
	-- rede:add(nn.Tanh())
	-- rede:add(modeloSaida)

	self._limpar(modeloEntrada.weight);
	self._limparBias(modeloEntrada.bias);
	self._limpar(modeloEntrada.gradWeight);
	self._limparBias(modeloEntrada.gradBias);

	
	for i = 1,2 do

		local entrada_o = {1,-1,-1,-1,1,-1,1,1,1,-1,-1,1,1,1,-1,-1,1,1,1,-1,1,-1,-1,-1,1}
		local saida_o = -1

		local entrada_x = {-1,1,1,1,-1,1,-1,1,-1,1,1,1,-1,1,1,1,-1,1,-1,1,-1,1,1,1,-1}
		local saida_x = 1

		local output = torch.Tensor(1)
		local input = 0;

		if i == 1 then
			input = torch.Tensor(entrada_o)
			output[1] = saida_o
		else
			input = torch.Tensor(entrada_x)
			output[1] = saida_x
		end


		-- Alimentando à rede neural e ao critério
		criterio:forward(rede:forward(input), output)

		-- treinar sobre este exemplo em 3 etapas
		-- (1) zero a acumulação dos gradientes
		rede:zeroGradParameters()

		-- (2) acumulam gradientes
		rede:backward(input, criterio:backward(rede.output, output))

		-- (3) atualizar parâmetros com uma taxa de aprendizado de 0,01
		rede:updateParameters(0.2)

	end

	self._rede = rede;
end
function RedeNeural.Hebb.determinarClassificacao(result)
    if result>=1 then
        return 'Letra O';
    elseif result<=-1 then
        return 'Letra X';
    end
    
    return 'Indeterminado';
        

end
function RedeNeural.Hebb:classificar()
	local rede = self._rede;

	local arquivos = RedeNeural.Arquivo:buscarArquivosClassificacao();

	for i = 1, #arquivos do

		local value = self._decodificarArquivo(arquivos[i])
		local input = torch.Tensor(value)

		local result = rede:forward(input)

		print(arquivos[i], self.determinarClassificacao(result[1]))
		print('')

	end


end