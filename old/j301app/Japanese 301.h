// Japanese 301.h : main header file for the JAPANESE 301 application
//

#if !defined(AFX_JAPANESE301_H__3779D2A1_D057_4774_8F7E_2F82933C9E32__INCLUDED_)
#define AFX_JAPANESE301_H__3779D2A1_D057_4774_8F7E_2F82933C9E32__INCLUDED_

#if _MSC_VER > 1000
#pragma once
#endif // _MSC_VER > 1000

#ifndef __AFXWIN_H__
	#error include 'stdafx.h' before including this file for PCH
#endif

#include "resource.h"       // main symbols

/////////////////////////////////////////////////////////////////////////////
// CJapanese301App:
// See Japanese 301.cpp for the implementation of this class
//

class CJapanese301App : public CWinApp
{
public:
	CJapanese301App();
	CHtmlView *view;

// Overrides
	// ClassWizard generated virtual function overrides
	//{{AFX_VIRTUAL(CJapanese301App)
	public:
	virtual BOOL InitInstance();
	//}}AFX_VIRTUAL

// Implementation
	//{{AFX_MSG(CJapanese301App)
	afx_msg void OnAppAbout();
		// NOTE - the ClassWizard will add and remove member functions here.
		//    DO NOT EDIT what you see in these blocks of generated code !
	//}}AFX_MSG
	DECLARE_MESSAGE_MAP()
};


/////////////////////////////////////////////////////////////////////////////

//{{AFX_INSERT_LOCATION}}
// Microsoft Visual C++ will insert additional declarations immediately before the previous line.

#endif // !defined(AFX_JAPANESE301_H__3779D2A1_D057_4774_8F7E_2F82933C9E32__INCLUDED_)
