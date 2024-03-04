//
//  FSGHomeViewController+Extension.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 25/11/22.
//

import Foundation
import UIKit
extension FSGHomeViewController{
    
    // MARK: Handle page controller-------------
    @IBAction func pageControlSelectionAction(_ sender: UIPageControl) {
        let page: Int? = sender.currentPage
        var frame: CGRect = self.collectionViewBanner.frame
        frame.origin.x = frame.size.width * CGFloat(page ?? 0)
        frame.origin.y = 0
        self.collectionViewBanner.scrollRectToVisible(frame, animated: true)
    }
    // MARK: handle buttons and underline in buttons-----------
    @IBAction func buttonSelectEventCategory(_ sender: UIButton) {
        self.eventCategorySelect(index: sender.tag)
    }
    func eventCategorySelect(index:Int){
        self.buttonSelectCategory.forEach{
            $0.isSelected = false
        }
        self.buttonUnderline.forEach{
            $0.isSelected = false
            $0.backgroundColor = .clear
            $0.setTitleColor(.white, for: .normal)
        }
        self.buttonSelectCategory[index].isSelected = true
        self.buttonUnderline[index].isSelected = true
        self.buttonUnderline[index].backgroundColor = .white
        self.buttonSelectCategory[index].setTitleColor(.white, for: .selected)
    }
    // MARK: handle banner image with page control---
    @objc func  slideToNext(){
        if currentIndex < arrImg.count-1{
            currentIndex = currentIndex + 1
        }else{
            currentIndex = 0
        }
        pageControl.currentPage = currentIndex
        collectionViewBanner.scrollToItem(at: IndexPath(item: currentIndex, section: 0), at: .right, animated: true)
        
    }
    @IBAction func openSideMenu(_ sender: Any) {
        self.present((AppDelegate.sharedInstance.setMenu()),animated: true)
    }
}

extension FSGHomeViewController: UITableViewDelegate, UITableViewDataSource{
    // MARK: extension for tableView---
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        self.popularEventHeight.constant = CGFloat(100 * Double(self.arrPopularImage.count))
        return arrPopularImage.count
    }
    
    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        let cell = tableView.dequeueReusableCell(withIdentifier: "PopularCell", for: indexPath) as! PopularEventTableViewCell
        cell.popularEventInage.image = arrPopularImage[indexPath.row]
        return cell
    }
    func tableView(_ tableView: UITableView, heightForRowAt indexPath: IndexPath) -> CGFloat {
        180
    }
}
extension FSGHomeViewController:UITextFieldDelegate{
    
}
// MARK: extention for colllectionView---
extension FSGHomeViewController:UICollectionViewDelegate, UICollectionViewDataSource, UICollectionViewDelegateFlowLayout{
    func collectionView(_ collectionView: UICollectionView, numberOfItemsInSection section: Int) -> Int {
        switch collectionView{
        case collectionViewBanner:
            return arrImg.count
        case eventCatagoryCollectionView:
            return arrCatagory.count
        default:
            return 0
        }
    }
    func collectionView(_ collectionView: UICollectionView, cellForItemAt indexPath: IndexPath) -> UICollectionViewCell {
        switch collectionView{
        case collectionViewBanner:
            let cell = collectionView.dequeueReusableCell(withReuseIdentifier: "BannerCollectionViewCell", for: indexPath) as! BannerCollectionViewCell
            cell.bannerImage.image = self.arrImg[indexPath.row]
            return cell
        case eventCatagoryCollectionView:
            let cell = collectionView.dequeueReusableCell(withReuseIdentifier: "CatagoryCollectionViewCell", for: indexPath) as! CatagoryCollectionViewCell
            cell.catagoryImage?.image = self.arrCatagory[indexPath.row]
            
            return cell
        default:
            return UICollectionViewCell()
        }
    }
    func collectionView(_ collectionView: UICollectionView, layout collectionViewLayout: UICollectionViewLayout, sizeForItemAt indexPath: IndexPath) -> CGSize {
        switch collectionView{
        case collectionViewBanner:
            return CGSize(width: self
                .collectionViewBanner.frame.width, height: self
                .collectionViewBanner.frame.height)
            
        case eventCatagoryCollectionView:
            if traitCollection.horizontalSizeClass == .regular && traitCollection.verticalSizeClass == .regular{
                let collectionWidth = eventCatagoryCollectionView.bounds.size.width/3
                let collectionHeight = eventCatagoryCollectionView.bounds.size.width/3.5
                return CGSize(width: collectionWidth-10 , height: collectionHeight-10)
            }else{
                let collectionWidth = eventCatagoryCollectionView.bounds.size.width/2
                let collectionHeight = eventCatagoryCollectionView.bounds.size.width/2.5
                return CGSize(width: collectionWidth-10 , height: collectionHeight-10)
            }
            
        default:
            break
        }
        return CGSize()
    }
    
}
// MARK: handle date picker---
extension FSGHomeViewController{
    func setupSelectDate(){
        if #available(iOS 13.4, *) {
            viewDate.frame = CGRect(x: 0, y: 0, width: self.view.bounds.width, height: 250.0)
            viewDate.frame = CGRect(x: 0, y: 0, width: self.view.bounds.width, height: 250.0)
            viewDate.preferredDatePickerStyle = .inline
            viewDate.preferredDatePickerStyle = .inline
        }
        
        self.viewDate.datePickerMode = .date
        let currentDate = Date()
        var dateComponents = DateComponents()
        let calendar = Calendar.init(identifier: .gregorian)
        dateComponents.year = 0
        let minDate = calendar.date(byAdding: dateComponents, to: currentDate)
        dateComponents.year = 100
        let maxDate = calendar.date(byAdding: dateComponents, to: currentDate)
        
        viewDate.maximumDate = maxDate
        viewDate.minimumDate = minDate
        self.datetextField.inputView = self.viewDate
        self.datetextField.inputAccessoryView = self.gettoolBar()
    }
    // MARK: Create function for gettingb toolbar--
    func gettoolBar() -> UIToolbar {
        let toolBar = UIToolbar()
        toolBar.barStyle = .default
        toolBar.isTranslucent = true
        let myColor : UIColor = UIColor( red: 2/255, green: 14/255, blue:70/255, alpha: 1.0 )
        toolBar.tintColor = myColor
        toolBar.sizeToFit()
        // Adding Button ToolBar
        let doneButton = UIBarButtonItem(title: "Done", style: .plain, target: self, action: #selector(DoneClick))
        let spaceButton = UIBarButtonItem(barButtonSystemItem: .flexibleSpace, target: nil, action: nil)
        let cancelButton = UIBarButtonItem(title: "Cancel", style: .plain, target: self, action: #selector(CancelClick))
        toolBar.setItems([cancelButton, spaceButton, doneButton], animated: false)
        toolBar.isUserInteractionEnabled = true
        return toolBar
    }
    // MARK: Done Button Click--
    @objc func DoneClick() {
        self.view.endEditing(true)
        let dateFormatter = DateFormatter()
        dateFormatter.dateFormat = "dd/MM/YYYY"
        self.datetextField.text = dateFormatter.string(from: self.viewDate.date)
        self.date = dateFormatter.string(from: viewDate.date)
        let datestr = dateFormatter.date(from: self.date ?? "")
        let dateStamp:TimeInterval = datestr!.timeIntervalSince1970
        self.timeStamp = Int(dateStamp)
        
    }
    @objc func CancelClick() {
        self.view.endEditing(true)
    }
}
