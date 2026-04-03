<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Support\SectionTitle;
use PHPUnit\Framework\TestCase;

final class SectionTitleTest extends TestCase
{
    public function test_pipe_split(): void
    {
        $p = SectionTitle::accentRest('  Avant | Après  ');
        $this->assertSame('Avant', $p['accent']);
        $this->assertSame('Après', $p['rest']);
    }

    public function test_comma_split(): void
    {
        $p = SectionTitle::accentRest('Normes et Rénovation, votre partenaire');
        $this->assertSame('Normes et Rénovation', $p['accent']);
        $this->assertSame('votre partenaire', $p['rest']);
    }

    public function test_no_separator_full_title_in_rest(): void
    {
        $p = SectionTitle::accentRest('Mentions légales');
        $this->assertSame('', $p['accent']);
        $this->assertSame('Mentions légales', $p['rest']);
    }

    public function test_empty_string(): void
    {
        $p = SectionTitle::accentRest('');
        $this->assertSame('', $p['accent']);
        $this->assertSame('', $p['rest']);
    }
}
