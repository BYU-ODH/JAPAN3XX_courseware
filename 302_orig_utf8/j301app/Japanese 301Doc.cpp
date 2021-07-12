// Japanese 301Doc.cpp : implementation of the CJapanese301Doc class
//

#include "stdafx.h"
#include "Japanese 301.h"

#include "Japanese 301Doc.h"

#ifdef _DEBUG
#define new DEBUG_NEW
#undef THIS_FILE
static char THIS_FILE[] = __FILE__;
#endif

/////////////////////////////////////////////////////////////////////////////
// CJapanese301Doc

IMPLEMENT_DYNCREATE(CJapanese301Doc, CDocument)

BEGIN_MESSAGE_MAP(CJapanese301Doc, CDocument)
	//{{AFX_MSG_MAP(CJapanese301Doc)
		// NOTE - the ClassWizard will add and remove mapping macros here.
		//    DO NOT EDIT what you see in these blocks of generated code!
	//}}AFX_MSG_MAP
END_MESSAGE_MAP()

/////////////////////////////////////////////////////////////////////////////
// CJapanese301Doc construction/destruction

CJapanese301Doc::CJapanese301Doc()
{
	// TODO: add one-time construction code here

}

CJapanese301Doc::~CJapanese301Doc()
{
}

BOOL CJapanese301Doc::OnNewDocument()
{
	if (!CDocument::OnNewDocument())
		return FALSE;

	// TODO: add reinitialization code here
	// (SDI documents will reuse this document)

	return TRUE;
}



/////////////////////////////////////////////////////////////////////////////
// CJapanese301Doc serialization

void CJapanese301Doc::Serialize(CArchive& ar)
{
	if (ar.IsStoring())
	{
		// TODO: add storing code here
	}
	else
	{
		// TODO: add loading code here
	}
}

/////////////////////////////////////////////////////////////////////////////
// CJapanese301Doc diagnostics

#ifdef _DEBUG
void CJapanese301Doc::AssertValid() const
{
	CDocument::AssertValid();
}

void CJapanese301Doc::Dump(CDumpContext& dc) const
{
	CDocument::Dump(dc);
}
#endif //_DEBUG

/////////////////////////////////////////////////////////////////////////////
// CJapanese301Doc commands
