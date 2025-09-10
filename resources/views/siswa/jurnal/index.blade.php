@extends('layout.main')

@section('content')
<style>
    .journal-header {
        background: white;
        border-radius: 15px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 2px 20px rgba(0,0,0,0.05);
        position: relative;
        overflow: hidden;
    }

    .journal-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 200px;
        background: linear-gradient(135deg, #667eea20, #764ba220);
        border-radius: 50%;
        transform: translate(50px, -50px);
    }

    .welcome-text {
        font-size: 28px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
    }

    .subtitle {
        color: #718096;
        font-size: 16px;
        margin-bottom: 20px;
    }

    .add-entry-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.2s;
        font-size: 14px;
        text-decoration: none;
        display: inline-block;
    }

    .add-entry-btn:hover {
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }

    .journal-section {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 2px 20px rgba(0,0,0,0.05);
    }

    .section-title {
        font-size: 22px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 30px;
    }

    .journal-grid {
        display: grid;
        gap: 20px;
    }

    .journal-card {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 24px;
        transition: all 0.3s;
        position: relative;
    }

    .journal-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        border-color: #667eea;
    }

    .journal-date {
        font-size: 14px;
        color: #667eea;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .journal-subject {
        font-size: 18px;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 12px;
    }

    .journal-content {
        color: #4a5568;
        line-height: 1.6;
        margin-bottom: 16px;
    }

    .journal-tags {
        display: flex;
        gap: 8px;
        margin-bottom: 16px;
        flex-wrap: wrap;
    }

    .tag {
        background: #edf2f7;
        color: #4a5568;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .tag.learning { background: #e6fffa; color: #047857; }
    .tag.task { background: #fef3c7; color: #92400e; }
    .tag.reflection { background: #e0e7ff; color: #3730a3; }
    .tag.prakerin { background: #fce7f3; color: #be185d; }

    .journal-actions {
        display: flex;
        gap: 8px;
        justify-content: flex-end;
        flex-wrap: wrap;
    }

    .action-btn {
        padding: 8px 12px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 12px;
        font-weight: 500;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .btn-view {
        background: #e0e7ff;
        color: #3730a3;
    }

    .btn-edit {
        background: #fef3c7;
        color: #92400e;
    }

    .btn-delete {
        background: #fee2e2;
        color: #dc2626;
    }

    .action-btn:hover {
        transform: translateY(-1px);
        text-decoration: none;
    }

    .btn-view:hover { color: #3730a3; }
    .btn-edit:hover { color: #92400e; }
    .btn-delete:hover { color: #dc2626; }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #718096;
    }

    .empty-icon {
        font-size: 48px;
        margin-bottom: 16px;
        opacity: 0.5;
    }

    .filter-section {
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
        flex-wrap: wrap;
        align-items: center;
    }

    .filter-btn {
        padding: 8px 16px;
        border: 1px solid #e2e8f0;
        background: white;
        color: #4a5568;
        border-radius: 20px;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
    }

    .filter-btn.active {
        background: #667eea;
        color: white;
        border-color: #667eea;
    }

    .filter-btn:hover {
        border-color: #667eea;
        color: #667eea;
        text-decoration: none;
    }

    .filter-btn.active:hover {
        color: white;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .journal-header {
            padding: 20px;
        }
        
        .welcome-text {
            font-size: 24px;
        }
        
        .journal-section {
            padding: 20px;
        }
        
        .journal-actions {
            justify-content: center;
        }
    }
</style>

<!-- Header Section -->
 <div class="container-xxl flex-grow-1 container-p-y">
<div class="journal-header">
    <div class="welcome-text">
        Jurnal Siswa 📖
    </div>
    <div class="subtitle">
        Catatan pembelajaran dan aktivitas harian Anda
    </div>
    <a href="" class="add-entry-btn">
        + Tambah Jurnal Baru
    </a>
</div>

<!-- Journal Section -->
<div class="journal-section">
    <h2 class="section-title">Jurnal PKL</h2>
    <div class="journal-grid">
        {{-- Loop through journal entries --}}
        @forelse($journals ?? [] as $journal)
        <div class="journal-card">
            <div class="journal-date">
                {{ \Carbon\Carbon::parse($journal->created_at ?? now())->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
            </div>
            <div class="journal-subject">
                {{ $journal->mata_pelajaran ?? 'Matematika - Trigonometri' }} 
            </div>
            <div class="journal-content">
                {{ Str::limit($journal->isi_jurnal ?? 'Hari ini mempelajari tentang fungsi trigonometri dasar (sin, cos, tan). Konsep yang dipelajari cukup menantang, terutama dalam menghapal rumus-rumus identitas trigonometri. Perlu latihan soal lebih banyak untuk memahami penerapannya.', 200) }}
            </div>
            
            {{-- Tags Section --}}
            <div class="journal-tags">
                @if(isset($journal->kategori))
                    @foreach(explode(',', $journal->kategori) as $tag)
                        <span class="tag {{ strtolower(trim($tag)) }}">{{ trim($tag) }}</span>
                    @endforeach
                @else
                    <span class="tag learning">Pembelajaran</span>
                    <span class="tag task">Tugas</span>
                @endif
            </div>
            
            {{-- Action Buttons --}}
            {{-- <div class="journal-actions">
                <a href="{{ route('jurnal.show', $journal->id ?? 1) }}" class="action-btn btn-view">
                    👁️ Lihat
                </a>
                <a href="{{ route('jurnal.edit', $journal->id ?? 1) }}" class="action-btn btn-edit">
                    ✏️ Edit
                </a>
                <form action="{{ route('jurnal.destroy', $journal->id ?? 1) }}" method="POST" style="display: inline;" 
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus jurnal ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="action-btn btn-delete">
                        🗑️ Hapus
                    </button>
                </form>
            </div> --}}
        </div>
        @empty
        {{-- Empty State --}}
        <div class="empty-state">
            <div class="empty-icon">📔</div>
            <h3>Belum ada jurnal</h3>
            <p>Mulai tulis jurnal pertama Anda hari ini!</p>
            <br>
            <a href="" class="add-entry-btn">
                + Tambah Jurnal Pertama
            </a>
        </div>
        @endforelse
    </div>
    
    {{-- Pagination if needed --}}
    @if(isset($journals) && method_exists($journals, 'links'))
    <div class="mt-4">
        {{ $journals->links() }}
    </div>
    @endif
</div>

{{-- Sample Data for Demo (remove when using real data) --}}
@if(!isset($journals))
<script>
    // This is just for demo purposes - remove when implementing with real data
    console.log('Demo data displayed. Connect to your controller and model for real data.');
</script>

<div class="journal-section mt-4">
    <h3 class="section-title">Demo Data (Hapus saat implementasi)</h3>
    <div class="journal-grid">
        <!-- Sample Entry 1 -->
        <div class="journal-card">
            <div class="journal-date">Senin, 9 September 2025</div>
            
            <div style="display: flex; gap: 15px; margin-bottom: 15px; font-size: 14px; color: #718096;">
                <span>🕐 07:00 - 15:30</span>
                <span>📷 Dengan foto</span>
            </div>
            
            <div class="journal-subject">Jurnal Hari Senin</div>
            <div class="journal-content">
                Hari ini mengikuti pembelajaran dari jam 7 pagi hingga 15:30. Mata pelajaran yang dipelajari meliputi Matematika, Bahasa Indonesia, dan praktik komputer. Mengerjakan tugas kelompok dan presentasi. Kegiatan berjalan lancar dan semua materi dapat dipahami dengan baik.
            </div>
            
            <div style="margin: 16px 0;">
                <div style="width: 100%; max-width: 200px; height: 120px; background: linear-gradient(45deg, #f0f0f0, #e0e0e0); border-radius: 8px; border: 2px solid #e2e8f0; display: flex; align-items: center; justify-content: center; color: #9ca3af;">
                    📷 Foto kegiatan
                </div>
            </div>
            
            <div class="journal-tags">
                <span class="tag" style="background: #d1fae5; color: #065f46;">✅ Disetujui</span>
                <span class="tag learning">Jurnal Harian</span>
            </div>
            <div class="journal-actions">
                <a href="#" class="action-btn btn-view">👁️ Lihat Detail</a>
                <button class="action-btn btn-delete" onclick="confirm('Demo: Hapus jurnal?')">🗑️ Hapus</button>
            </div>
        </div>

        <!-- Sample Entry 2 -->
        <div class="journal-card">
            <div class="journal-date">Jumat, 6 September 2025</div>
            
            <div style="display: flex; gap: 15px; margin-bottom: 15px; font-size: 14px; color: #718096;">
                <span>🕐 07:00 - 12:00</span>
            </div>
            
            <div class="journal-subject">Jurnal Hari Jumat</div>
            <div class="journal-content">
                Pembelajaran hari Jumat lebih singkat, selesai jam 12. Fokus pada mata pelajaran agama dan olahraga. Melakukan kegiatan kebersihan sekolah bersama-sama. Suasana lebih santai menjelang akhir pekan.
            </div>
            
            <div class="journal-tags">
                <span class="tag" style="background: #fef3c7; color: #92400e;">⏳ Menunggu</span>
                <span class="tag learning">Jurnal Harian</span>
            </div>
            <div class="journal-actions">
                <a href="#" class="action-btn btn-view">👁️ Lihat Detail</a>
                <a href="#" class="action-btn btn-edit">✏️ Edit</a>
                <button class="action-btn btn-delete" onclick="confirm('Demo: Hapus jurnal?')">🗑️ Hapus</button>
            </div>
        </div>

        <!-- Sample Entry 3 -->
        <div class="journal-card">
            <div class="journal-date">Rabu, 4 September 2025</div>
            
            <div style="display: flex; gap: 15px; margin-bottom: 15px; font-size: 14px; color: #718096;">
                <span>🕐 07:00 - 14:00</span>
                <span>📷 Dengan foto</span>
            </div>
            
            <div class="journal-subject">Jurnal Hari Rabu</div>
            <div class="journal-content">
                Hari praktikum di laboratorium komputer. Belajar membuat website sederhana dengan HTML dan CSS. Mengikuti ujian praktik dan mendapat nilai yang memuaskan. Dokumentasi hasil praktikum sudah difoto.
            </div>
            
            <div style="margin: 16px 0;">
                <div style="width: 100%; max-width: 200px; height: 120px; background: linear-gradient(45deg, #f0f0f0, #e0e0e0); border-radius: 8px; border: 2px solid #e2e8f0; display: flex; align-items: center; justify-content: center; color: #9ca3af;">
                    📷 Praktikum lab
                </div>
            </div>
            
            <div class="journal-tags">
                <span class="tag" style="background: #fee2e2; color: #dc2626;">❌ Perlu Perbaikan</span>
                <span class="tag learning">Jurnal Harian</span>
            </div>
            <div class="journal-actions">
                <a href="#" class="action-btn btn-view">👁️ Lihat Detail</a>
                <a href="#" class="action-btn btn-edit">✏️ Edit</a>
                <button class="action-btn btn-delete" onclick="confirm('Demo: Hapus jurnal?')">🗑️ Hapus</button>
            </div>
        </div>
    </div>
</div>
 </div>
@endif
@endsection