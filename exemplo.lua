require 'torch'
require 'nn'

--[[
local entrada_o = {1,-1,-1,-1,1,-1,1,1,1,-1,-1,1,1,1,-1,-1,1,1,1,-1,1,-1,-1,-1,1}
local saida_x = 1



local input = torch.randn(25)
local output = torch.Tensor(entrada_o)

print(input)
print(output)

-- ---------------------------------------

mlp = nn.Sequential()

inputSize = 10
hiddenLayer1Size = 10
hiddenLayer2Size = 10
nclasses = 2


mlp:add(nn.Linear(inputSize, hiddenLayer1Size))
mlp:add(nn.Tanh())
mlp:add(nn.Linear(hiddenLayer1Size, hiddenLayer2Size))
mlp:add(nn.Tanh())
mlp:add(nn.Linear(hiddenLayer2Size, nclasses))
mlp:add(nn.LogSoftMax())

out = mlp:forward(torch.randn(1,10))
print(out)
]]

 module= nn.Linear(10,5)  -- 10 inputs, 5 outputs



 mlp = nn.Sequential();
 mlp:add(module)



 print(module.weight)


