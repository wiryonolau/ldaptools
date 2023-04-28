<?php

namespace LdapTools\AttributeConverter;

class ConvertIpAddress implements AttributeConverterInterface
{
    use AttributeConverterTrait;

    /**
     * {@inheritdoc}
     */
    public function toLdap($value)
    {
        $long = ip2long($value);
        if ($long == -1 || $long === FALSE) {
            return 0;
        } else {
            return (sprintf("%u", ip2long($value)));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function fromLdap($value)
    {
        return long2ip((float)$value);
    }
}
