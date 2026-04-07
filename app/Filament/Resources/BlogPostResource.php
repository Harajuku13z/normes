<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogPostResource\Pages;
use App\Models\BlogPost;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BlogPostResource extends Resource
{
    protected static ?string $model = BlogPost::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Blog';

    protected static ?string $modelLabel = 'Article';

    protected static ?string $pluralModelLabel = 'Articles';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Contenu')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('Titre')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, callable $set) {
                                if (is_string($state) && trim($state) !== '') {
                                    $set('slug', Str::slug($state));
                                    if (! $set('meta_title', null)) {
                                        // noop
                                    }
                                }
                            }),

                        TextInput::make('slug')
                            ->label('Slug (URL)')
                            ->helperText('Généré automatiquement depuis le titre si vide.')
                            ->required()
                            ->unique(ignoreRecord: true),

                        Textarea::make('excerpt')
                            ->label('Accroche / Extrait')
                            ->rows(3)
                            ->columnSpanFull(),

                        RichEditor::make('content_html')
                            ->label('Contenu (landing)')
                            ->columnSpanFull()
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('blog')
                            ->fileAttachmentsVisibility('public'),
                    ]),

                Section::make('Images & SEO')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('featured_image')
                            ->label('Image mise en avant')
                            ->disk('public')
                            ->directory('blog/featured')
                            ->visibility('public')
                            ->image()
                            ->imageEditor()
                            ->helperText('Utilisée sur la liste + hero de l’article.'),

                        FileUpload::make('og_image')
                            ->label('OG image (optionnel)')
                            ->disk('public')
                            ->directory('blog/og')
                            ->visibility('public')
                            ->image()
                            ->imageEditor(),

                        TextInput::make('meta_title')
                            ->label('Meta title')
                            ->maxLength(255),

                        Textarea::make('meta_description')
                            ->label('Meta description')
                            ->rows(3)
                            ->columnSpanFull(),

                        TextInput::make('meta_keywords')
                            ->label('Mots clés (optionnel)')
                            ->helperText('Séparés par des virgules.')
                            ->columnSpanFull(),

                        TextInput::make('canonical_url')
                            ->label('Canonical (optionnel)')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featured_image')
                    ->label('')
                    ->square()
                    ->size(48),
                TextColumn::make('title')
                    ->label('Titre')
                    ->searchable()
                    ->sortable()
                    ->limit(60)
                    ->weight('bold'),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('published_at')
                    ->label('Publié')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('MAJ')
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('published_at', 'desc')
            ->actions([
                \Filament\Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                \Filament\Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogPosts::route('/'),
            'create' => Pages\CreateBlogPost::route('/create'),
            'edit' => Pages\EditBlogPost::route('/{record}/edit'),
        ];
    }
}

