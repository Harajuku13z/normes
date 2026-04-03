<?php

namespace Tests\Unit;

use App\Support\VimeoEmbed;
use PHPUnit\Framework\TestCase;

class VimeoEmbedTest extends TestCase
{
    public function test_parse_standard_vimeo_url(): void
    {
        $m = VimeoEmbed::parse('https://vimeo.com/123456789');
        $this->assertSame(['id' => '123456789', 'h' => null], $m);
    }

    public function test_parse_player_url_with_h(): void
    {
        $m = VimeoEmbed::parse('https://player.vimeo.com/video/999?h=abcd1234efgh');
        $this->assertSame('999', $m['id']);
        $this->assertSame('abcd1234efgh', $m['h']);
    }

    public function test_parse_returns_null_for_non_vimeo(): void
    {
        $this->assertNull(VimeoEmbed::parse('https://example.com/video.mp4'));
    }

    public function test_iframe_src_contains_video_id(): void
    {
        $src = VimeoEmbed::iframeSrc(['id' => '123', 'h' => null]);
        $this->assertStringContainsString('player.vimeo.com/video/123', $src);
        $this->assertStringContainsString('muted=1', $src);
    }
}
