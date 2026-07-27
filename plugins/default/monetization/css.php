/** <style> **/
.menu-topbar-dropdown-campaignspending:before,
.menu-section-item-campaigns:before {
	content: "\f641" !important;
}

.ossn-campaign-dashboard {}

.ossn-campaign-dashboard .dashboard-header-row {
	display: flex;
	justify-content: space-between;
	align-items: center;
	margin-bottom: 20px;
}

.ossn-campaign-dashboard .dashboard-title {
	margin: 0;
	font-size: 1.35rem;
	font-weight: 700;
	color: #1a202c;
}

.ossn-campaign-dashboard .btn-launch-new {
	background-color: #0d6efd;
	color: #ffffff !important;
	padding: 8px 16px;
	border-radius: 6px;
	font-weight: 600;
	font-size: 0.875rem;
	text-decoration: none !important;
	transition: background-color 0.2s ease-in-out;
}

.ossn-campaign-dashboard .btn-launch-new:hover {
	background-color: #0b5ed7;
}

/* Table Design */
.ossn-campaign-dashboard .table-campaigns {
	border-collapse: separate;
	border-spacing: 0;
	width: 100%;
}

.ossn-campaign-dashboard .table-campaigns thead th {
	background-color: #f8f9fa;
	color: #6c757d;
	font-size: 0.75rem;
	text-transform: uppercase;
	letter-spacing: 0.6px;
	font-weight: 700;
	padding: 12px 14px;
	border-bottom: 1px solid #e9ecef;
}

.ossn-campaign-dashboard .table-campaigns tbody td {
	padding: 14px;
	border-bottom: 1px solid #f1f3f5;
	vertical-align: middle;
}

/* Metrics & Submetrics Fix */
.ossn-campaign-dashboard .campaign-metric {
	display: block;
	font-size: 0.95rem;
	font-weight: 700;
	color: #212529;
	line-height: 1.2;
}

.ossn-campaign-dashboard .campaign-submetric {
	display: inline-block;
	font-size: 0.75rem;
	color: #6c757d;
	margin-top: 3px;
	font-weight: 500;
}

.ossn-campaign-dashboard .campaign-submetric.mode-badge {
	background-color: #e9ecef;
	color: #495057;
	padding: 2px 8px;
	border-radius: 12px;
	text-transform: capitalize;
	font-size: 0.7rem;
}

/* Badges */
.ossn-campaign-dashboard .campaign-badge {
	display: inline-block;
	padding: 4px 10px;
	border-radius: 20px;
	font-size: 0.75rem;
	font-weight: 600;
	text-transform: capitalize;
}

/* Action Buttons */
.ossn-campaign-dashboard .action-btn-icon {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	width: 32px;
	height: 32px;
	border-radius: 50%;
	color: #dc3545 !important;
	background-color: #f8d7da;
	text-decoration: none !important;
	transition: all 0.2s ease;
}

.ossn-campaign-dashboard .action-btn-icon:hover {
	background-color: #dc3545;
	color: #ffffff !important;
	transform: scale(1.08);
}

.ossn-campaign-dashboard .badge-active {
	background: #dcfce7;
	color: #166534;
}

.ossn-campaign-dashboard .badge-pending {
	background: #fef3c7;
	color: #92400e;
}

.ossn-campaign-dashboard .badge-declined {
	background: #fee2e2;
	color: #991b1b;
}

.ossn-campaign-dashboard .badge-expired {
	background: #f1f5f9;
	color: #475569;
}


.monetization-builder-container {
	background: var(--bs-body-bg, #ffffff);
	border: 1px solid var(--bs-border-color, #e2e8f0);
	border-radius: 12px;
	padding: 24px;
}

.monetization-split-grid {
	display: grid;
	grid-template-columns: 1fr 360px;
	gap: 28px;
	align-items: start;
}

/* Input Fields & Cards */
.builder-card {
	background: var(--bs-tertiary-bg, #f8fafc);
	border: 1px solid var(--bs-border-color, #e2e8f0);
	border-radius: 10px;
	padding: 18px;
	margin-bottom: 20px;
}

.builder-card-title {
	font-size: 0.95rem;
	font-weight: 700;
	color: var(--bs-heading-color, #0f172a);
	margin-bottom: 14px;
	display: flex;
	align-items: center;
	gap: 8px;
}

.builder-card-title i {
	color: #2563eb;
}

.form-label-modern {
	font-weight: 600;
	font-size: 0.825rem;
	color: var(--bs-body-color, #334155);
	margin-bottom: 6px;
	display: block;
}

.form-control-modern {
	width: 100%;
	padding: 10px 14px;
	border-radius: 8px;
	border: 1px solid var(--bs-border-color, #cbd5e1);
	background: var(--bs-body-bg, #ffffff);
	color: var(--bs-body-color, #0f172a);
	font-size: 0.9rem;
	transition: all 0.15s ease;
}

.form-control-modern:focus {
	border-color: #2563eb;
	box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
	outline: none;
}

/* Custom Segmented Checkbox Pills & OSSN Reset */
.custom-pill-checkboxes {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
}

.custom-pill-checkboxes label {
	display: inline-flex !important;
	align-items: center !important;
	justify-content: center !important;
	gap: 8px !important;
	padding: 8px 16px !important;
	background: #ffffff !important;
	border: 1px solid #cbd5e1 !important;
	border-radius: 50px !important;
	font-size: 0.85rem !important;
	font-weight: 600 !important;
	color: #334155 !important;
	cursor: pointer !important;
	transition: all 0.2s ease !important;
	user-select: none !important;
	box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03) !important;
	margin: 0 !important;
}

.custom-pill-checkboxes label:hover {
	border-color: #2563eb !important;
	color: #2563eb !important;
	background: #f8fafc !important;
}

.custom-pill-checkboxes input[type="checkbox"],
.ossn-form .custom-pill-checkboxes input[type="checkbox"] {
	position: static !important;
	top: 0 !important;
	margin: 0 !important;
	padding: 0 !important;
	appearance: auto !important;
	-webkit-appearance: checkbox !important;
	-moz-appearance: checkbox !important;
	width: 16px !important;
	height: 16px !important;
	cursor: pointer !important;
	accent-color: #2563eb !important;
	flex-shrink: 0 !important;
	vertical-align: middle !important;
}

.custom-pill-checkboxes input[type="checkbox"]::before,
.custom-pill-checkboxes input[type="checkbox"]::after,
.ossn-form .custom-pill-checkboxes input[type="checkbox"]:checked::before,
.ossn-form .custom-pill-checkboxes input[type="checkbox"]:checked::after {
	content: none !important;
	display: none !important;
}

.custom-pill-checkboxes label:has(input[type="checkbox"]:checked) {
	border-color: #2563eb !important;
	background-color: #eff6ff !important;
	color: #1d4ed8 !important;
}

.billing-mode-selector {
	display: flex;
	gap: 12px;
}

.billing-mode-card {
	flex: 1;
	position: relative;
	border: 2px solid var(--bs-border-color, #e2e8f0);
	border-radius: 10px;
	padding: 12px 14px;
	cursor: pointer;
	background: var(--bs-body-bg, #ffffff);
	transition: all 0.2s ease;
}

.billing-mode-card:hover {
	border-color: #93c5fd;
}

.billing-mode-card.active {
	border-color: #2563eb;
	background: rgba(37, 99, 235, 0.03);
}

.billing-mode-card input[type="radio"] {
	position: absolute;
	opacity: 0;
	pointer-events: none;
}

.monetization-builder-container .mode-badge-title {
	font-weight: 700;
	font-size: 0.875rem;
	color: var(--bs-heading-color, #1e293b);
	display: block;
}

.monetization-builder-container .mode-badge-desc {
	font-size: 0.75rem;
	color: var(--bs-secondary-color, #64748b);
	display: block;
	margin-top: 2px;
}

/* Dropzone Upload Styling */
.monetization-builder-container .dropzone-upload-box {
	border: 2px dashed var(--bs-border-color, #cbd5e1);
	border-radius: 10px;
	padding: 24px;
	text-align: center;
	background: var(--bs-body-bg, #ffffff);
	cursor: pointer;
	transition: all 0.2s ease;
}

.monetization-builder-container .dropzone-upload-box:hover {
	border-color: #2563eb;
	background: rgba(37, 99, 235, 0.02);
}

.monetization-builder-container .dropzone-icon {
	width: 44px;
	height: 44px;
	background: #eff6ff;
	color: #2563eb;
	border-radius: 50%;
	display: inline-flex;
	align-items: center;
	justify-content: center;
	font-size: 18px;
	margin-bottom: 8px;
}

/* Interactive Live Ad Preview Box */
.sticky-preview-wrapper {
	position: sticky;
	top: 20px;
}

.preview-box-container {
	background: var(--bs-body-bg, #ffffff);
	border: 1px solid var(--bs-border-color, #e2e8f0);
	border-radius: 12px;
	overflow: hidden;
	box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
}

.preview-box-header {
	background: var(--bs-tertiary-bg, #f1f5f9);
	padding: 10px 14px;
	font-size: 0.75rem;
	font-weight: 700;
	text-transform: uppercase;
	letter-spacing: 0.5px;
	color: var(--bs-secondary-color, #64748b);
	border-bottom: 1px solid var(--bs-border-color, #e2e8f0);
}

.preview-clickable-card {
	display: block;
	text-decoration: none !important;
	color: inherit !important;
	padding: 14px;
	transition: background-color 0.2s ease;
}

.preview-clickable-card:hover {
	background-color: #f8fafc;
}

.mock-ad-title {
	font-size: 0.95rem;
	font-weight: 700;
	color: var(--bs-heading-color, #0f172a);
	margin-bottom: 8px;
	line-height: 1.35;
}

.preview-clickable-card:hover .mock-ad-title {
	color: #2563eb;
}

.mock-sponsored-meta {
	display: flex;
	align-items: center;
	justify-content: space-between;
	margin-bottom: 8px;
}

.mock-sponsored-badge {
	font-size: 0.68rem;
	font-weight: 700;
	text-transform: uppercase;
	letter-spacing: 0.5px;
	color: #2563eb;
	background-color: #eff6ff;
	padding: 2px 8px;
	border-radius: 4px;
}

.mock-domain-preview {
	font-size: 0.75rem;
	color: var(--bs-secondary-color, #64748b);
	font-weight: 600;
}

/* 1200x630 Aspect Ratio Frame with Zero Cropping */
.mock-ad-image-frame {
	width: 100%;
	aspect-ratio: 1200 / 630;
	height: auto;
	background: #f1f5f9;
	border-radius: 8px;
	overflow: hidden;
	display: flex;
	align-items: center;
	justify-content: center;
	color: #94a3b8;
	border: 1px solid var(--bs-border-color, #e2e8f0);
	margin-bottom: 10px;
}

.mock-ad-image-frame img {
	width: 100%;
	height: 100%;
	object-fit: contain !important;
}


.mock-ad-desc {
	font-size: 0.825rem;
	color: var(--bs-body-color, #475569);
	word-break: break-word;
	line-height: 1.45;
}

/* Light Checkout Summary Card */
.checkout-summary-card {
	background: var(--bs-body-bg, #ffffff);
	border: 1px solid var(--bs-border-color, #e2e8f0);
	border-radius: 12px;
	padding: 18px;
	margin-top: 16px;
	box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
}

.checkout-summary-card .price-tag {
	font-size: 1.75rem;
	font-weight: 800;
	color: #2563eb;
}

.btn-launch-campaign {
	width: 100%;
	background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
	color: #ffffff;
	font-weight: 700;
	font-size: 0.95rem;
	padding: 12px;
	border-radius: 8px;
	border: none;
	margin-top: 14px;
	transition: all 0.15s ease;
	cursor: pointer;
}

.btn-launch-campaign:hover {
	filter: brightness(1.08);
	box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3);
}

@media (max-width: 992px) {
	.monetization-split-grid {
		grid-template-columns: 1fr;
	}
}