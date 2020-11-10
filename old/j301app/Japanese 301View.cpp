// Japanese 301View.cpp : implementation of the CJapanese301View class
//

#include "stdafx.h"
#include "Japanese 301.h"

#include "Japanese 301Doc.h"
#include "Japanese 301View.h"

#ifdef _DEBUG
#define new DEBUG_NEW
#undef THIS_FILE
static char THIS_FILE[] = __FILE__;
#endif

/////////////////////////////////////////////////////////////////////////////
// CJapanese301View

IMPLEMENT_DYNCREATE(CJapanese301View, CHtmlView)

BEGIN_MESSAGE_MAP(CJapanese301View, CHtmlView)
	//{{AFX_MSG_MAP(CJapanese301View)
	ON_COMMAND(ID_FILE_START, OnFileStart)
	ON_COMMAND(ID_FILE_INDEX, OnFileIndex)
	//}}AFX_MSG_MAP
END_MESSAGE_MAP()

/////////////////////////////////////////////////////////////////////////////
// CJapanese301View construction/destruction

CJapanese301View::CJapanese301View()
{
	// TODO: add construction code here
	char cwd[255];
	GetCurrentDirectory(255, cwd);
	url_base.Format("%s/", cwd);
	url_base.Replace('\\', '/');
	url_base.Replace("//", "/");
	url_base = "file://" + url_base;

	((CJapanese301App *) AfxGetApp())->view = this;

}

CJapanese301View::~CJapanese301View()
{
}

BOOL CJapanese301View::PreCreateWindow(CREATESTRUCT& cs)
{
	// TODO: Modify the Window class or styles here by modifying
	//  the CREATESTRUCT cs

	return CHtmlView::PreCreateWindow(cs);
}

/////////////////////////////////////////////////////////////////////////////
// CJapanese301View drawing

void CJapanese301View::OnDraw(CDC* pDC)
{
	CJapanese301Doc* pDoc = GetDocument();
	ASSERT_VALID(pDoc);
	// TODO: add draw code for native data here
}

void CJapanese301View::OnInitialUpdate()
{
	CHtmlView::OnInitialUpdate();

	// TODO: This code navigates to a popular spot on the web.
	//  change the code to go where you'd like.
	Navigate2(_T(url_base + "index.html"), NULL, NULL);
}

/////////////////////////////////////////////////////////////////////////////
// CJapanese301View diagnostics

#ifdef _DEBUG
void CJapanese301View::AssertValid() const
{
	CHtmlView::AssertValid();
}

void CJapanese301View::Dump(CDumpContext& dc) const
{
	CHtmlView::Dump(dc);
}

CJapanese301Doc* CJapanese301View::GetDocument() // non-debug version is inline
{
	ASSERT(m_pDocument->IsKindOf(RUNTIME_CLASS(CJapanese301Doc)));
	return (CJapanese301Doc*)m_pDocument;
}
#endif //_DEBUG

/////////////////////////////////////////////////////////////////////////////
// CJapanese301View message handlers

void CJapanese301View::OnFileStart() 
{
	// TODO: Add your command handler code here
	Navigate2(_T(url_base + "index.html"), NULL, NULL);
}

void CJapanese301View::OnFileIndex() 
{
	// TODO: Add your command handler code here
	Navigate2(_T(url_base + "l_index.html"), NULL, NULL);

}
