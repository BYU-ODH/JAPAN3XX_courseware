// Japanese 301Doc.h : interface of the CJapanese301Doc class
//
/////////////////////////////////////////////////////////////////////////////

#if !defined(AFX_JAPANESE301DOC_H__F865C9E2_8103_4D4D_B398_FC43E351CB63__INCLUDED_)
#define AFX_JAPANESE301DOC_H__F865C9E2_8103_4D4D_B398_FC43E351CB63__INCLUDED_

#if _MSC_VER > 1000
#pragma once
#endif // _MSC_VER > 1000


class CJapanese301Doc : public CDocument
{
protected: // create from serialization only
	CJapanese301Doc();
	DECLARE_DYNCREATE(CJapanese301Doc)

// Attributes
public:

// Operations
public:

// Overrides
	// ClassWizard generated virtual function overrides
	//{{AFX_VIRTUAL(CJapanese301Doc)
	public:
	virtual BOOL OnNewDocument();
	virtual void Serialize(CArchive& ar);
	//}}AFX_VIRTUAL

// Implementation
public:
	CHtmlView *view;
	virtual ~CJapanese301Doc();
#ifdef _DEBUG
	virtual void AssertValid() const;
	virtual void Dump(CDumpContext& dc) const;
#endif

protected:

// Generated message map functions
protected:
	//{{AFX_MSG(CJapanese301Doc)
		// NOTE - the ClassWizard will add and remove member functions here.
		//    DO NOT EDIT what you see in these blocks of generated code !
	//}}AFX_MSG
	DECLARE_MESSAGE_MAP()
};

/////////////////////////////////////////////////////////////////////////////

//{{AFX_INSERT_LOCATION}}
// Microsoft Visual C++ will insert additional declarations immediately before the previous line.

#endif // !defined(AFX_JAPANESE301DOC_H__F865C9E2_8103_4D4D_B398_FC43E351CB63__INCLUDED_)
