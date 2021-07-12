// Japanese 301View.h : interface of the CJapanese301View class
//
/////////////////////////////////////////////////////////////////////////////

#if !defined(AFX_JAPANESE301VIEW_H__924E6F5A_74F5_4128_83EE_3C346D58C234__INCLUDED_)
#define AFX_JAPANESE301VIEW_H__924E6F5A_74F5_4128_83EE_3C346D58C234__INCLUDED_

#if _MSC_VER > 1000
#pragma once
#endif // _MSC_VER > 1000


class CJapanese301View : public CHtmlView
{
protected: // create from serialization only
	CJapanese301View();
	DECLARE_DYNCREATE(CJapanese301View)

// Attributes
public:
	CJapanese301Doc* GetDocument();

// Operations
public:

// Overrides
	// ClassWizard generated virtual function overrides
	//{{AFX_VIRTUAL(CJapanese301View)
	public:
	virtual void OnDraw(CDC* pDC);  // overridden to draw this view
	virtual BOOL PreCreateWindow(CREATESTRUCT& cs);
	protected:
	virtual void OnInitialUpdate(); // called first time after construct
	//}}AFX_VIRTUAL

// Implementation
public:
	virtual ~CJapanese301View();
#ifdef _DEBUG
	virtual void AssertValid() const;
	virtual void Dump(CDumpContext& dc) const;
#endif

protected:

// Generated message map functions
protected:
	CString url_base;
	//{{AFX_MSG(CJapanese301View)
	afx_msg void OnFileStart();
	afx_msg void OnFileIndex();
	//}}AFX_MSG
	DECLARE_MESSAGE_MAP()
};

#ifndef _DEBUG  // debug version in Japanese 301View.cpp
inline CJapanese301Doc* CJapanese301View::GetDocument()
   { return (CJapanese301Doc*)m_pDocument; }
#endif

/////////////////////////////////////////////////////////////////////////////

//{{AFX_INSERT_LOCATION}}
// Microsoft Visual C++ will insert additional declarations immediately before the previous line.

#endif // !defined(AFX_JAPANESE301VIEW_H__924E6F5A_74F5_4128_83EE_3C346D58C234__INCLUDED_)
