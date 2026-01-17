<?php

namespace Tigusigalpa\YandexGPT\Models;

class ReasoningOptions
{
    const MODE_DISABLED = 'DISABLED';
    const MODE_ENABLED_HIDDEN = 'ENABLED_HIDDEN';
    
    const EFFORT_LOW = 'low';
    const EFFORT_MEDIUM = 'medium';
    const EFFORT_HIGH = 'high';

    private string $mode;
    private ?string $effort;

    public function __construct(string $mode = self::MODE_DISABLED, ?string $effort = null)
    {
        $this->setMode($mode);
        $this->setEffort($effort);
    }

    public static function disabled(): self
    {
        return new self(self::MODE_DISABLED);
    }

    public static function enabledHidden(?string $effort = null): self
    {
        return new self(self::MODE_ENABLED_HIDDEN, $effort);
    }

    public function setMode(string $mode): self
    {
        if (!in_array($mode, [self::MODE_DISABLED, self::MODE_ENABLED_HIDDEN])) {
            throw new \InvalidArgumentException("Invalid reasoning mode: {$mode}");
        }
        $this->mode = $mode;
        return $this;
    }

    public function setEffort(?string $effort): self
    {
        if ($effort !== null && !in_array($effort, [self::EFFORT_LOW, self::EFFORT_MEDIUM, self::EFFORT_HIGH])) {
            throw new \InvalidArgumentException("Invalid reasoning effort: {$effort}");
        }
        $this->effort = $effort;
        return $this;
    }

    public function getMode(): string
    {
        return $this->mode;
    }

    public function getEffort(): ?string
    {
        return $this->effort;
    }

    public function toArray(): array
    {
        $result = ['mode' => $this->mode];
        
        if ($this->effort !== null) {
            $result['effort'] = $this->effort;
        }
        
        return $result;
    }

    public static function isValidMode(string $mode): bool
    {
        return in_array($mode, [self::MODE_DISABLED, self::MODE_ENABLED_HIDDEN]);
    }

    public static function isValidEffort(string $effort): bool
    {
        return in_array($effort, [self::EFFORT_LOW, self::EFFORT_MEDIUM, self::EFFORT_HIGH]);
    }
}
