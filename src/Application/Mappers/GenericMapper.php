<?php

namespace Src\Application\Mappers;

use Illuminate\Support\Collection;
use ReflectionClass;
use ReflectionProperty;
use stdClass;
use Exception;

class GenericMapper
{
    /**
     * Mapeia um model único para uma entidade
     *
     * @template T
     * @param object|Collection $source - Model ou Collection com um objeto
     * @param class-string<T> $targetClass - Classe da entidade de destino
     * @return T - Retorna instância da classe especificada
     * @throws Exception - Se houver erro na conversão ou campo obrigatório faltando
     */
    public static function map($source, string $targetClass): object
    {
        // Se for Collection, pegar o primeiro item
        if ($source instanceof Collection) {
            $source = $source->first();
        }

        if (!$source) {
            throw new Exception("Source inválido ou vazio para mapear para {$targetClass}");
        }

        try {
            $errors = [];
            $data = [];

            // Converter array para stdClass se necessário
            if (is_array($source)) {
                $source = (object)$source;
            }

            // Reflection da classe de destino
            $reflection = new ReflectionClass($targetClass);
            $properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);

            foreach ($properties as $property) {
                $propertyName = $property->getName();
                $snakeCaseName = self::camelToSnake($propertyName);

                // Tentar pegar o valor do source
                $value = null;
                $found = false;

                // Tentar camelCase
                if (isset($source->$propertyName)) {
                    $value = $source->$propertyName;
                    $found = true;
                }
                // Tentar snake_case
                elseif (isset($source->$snakeCaseName)) {
                    $value = $source->$snakeCaseName;
                    $found = true;
                }

                // Validar se o campo é obrigatório (não pode ser null)
                $isNullable = $property->getType() && $property->getType()->allowsNull();

                if (!$found && !$isNullable) {
                    $errors[] = "Campo obrigatório '{$propertyName}' não encontrado no source.";
                } else {
                    // Converter tipo se necessário
                    if ($found && $value !== null && $property->getType()) {
                        $value = self::castValue($value, $property->getType()->getName());
                    }
                    $data[$propertyName] = $value ?? null;
                }
            }

            // Se houver erros, lançar exceção
            if (!empty($errors)) {
                throw new Exception("Erro ao mapear para {$targetClass}: " . implode(', ', $errors));
            }

            // Instanciar a classe com os dados mapeados
            return new $targetClass(...$data);
        } catch (Exception $e) {
            throw new Exception("Erro ao mapear para {$targetClass}: " . $e->getMessage());
        }
    }

    /**
     * Converte camelCase para snake_case
     *
     * @param string $str
     * @return string
     */
    private static function camelToSnake(string $str): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $str));
    }

    /**
     * Converte um valor para o tipo especificado
     *
     * @param mixed $value
     * @param string $type
     * @return mixed
     */
    private static function castValue($value, string $type)
    {
        return match ($type) {
            'int' => (int)$value,
            'float' => (float)$value,
            'string' => (string)$value,
            'bool' => (bool)$value,
            'array' => (array)$value,
            default => $value,
        };
    }
}
